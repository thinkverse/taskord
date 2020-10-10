<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Webhook;
use App\Notifications\VersionReleased;
use Carbon\Carbon;
use GrahamCampbell\Throttle\Facades\Throttle;
use GuzzleHttp\Client;
use Helper;
use Illuminate\Http\Request as WebhookRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class WebhookController extends Controller
{
    public function createTask($webhook, $task, $done, $done_at, $product_id, $type)
    {
        $ignoreList = [
            'styleci',
            'merge pull request',
        ];

        if (! Str::contains(strtolower($task), $ignoreList)) {
            $webhook->user->touch();
            $task = Task::create([
                'user_id' =>  $webhook->user_id,
                'task' => $task,
                'done' => $done,
                'done_at' => $done_at,
                'product_id' => $product_id,
                'type' => $product_id ? 'product' : 'user',
                'source' => $type,
            ]);
        }
    }

    public function web($token, WebhookRequest $request)
    {
        $throttler = Throttle::get(Request::instance(), 50, 5);
        $throttler->hit();
        if (count($throttler) > 60) {
            Helper::flagAccount(Auth::user());
        }
        if (! $throttler->check()) {
            return response()->json([
                'message' => 'Your are rate limited, try again later!',
            ], 429);
        }

        $webhook = Webhook::where('token', $token)->first();
        if (! $webhook) {
            return response()->json([
                'message' => 'No webhook exists',
            ], 401);
        }

        if (User::find($webhook->user_id)->isFlagged) {
            return response()->json([
                'message' => 'Your account is flagged!',
            ], 401);
        }

        if ($webhook->type === 'web') {
            $request_body = $request->json()->all();
            if (
                ! array_key_exists('task', $request_body) or
                ! array_key_exists('done', $request_body)
            ) {
                return response()->json([
                    'message' => 'Invalid parameters',
                ], 422);
            }
            if ($request_body['done']) {
                $done_at = Carbon::now();
            } else {
                $done_at = null;
            }

            $this->createTask(
                $webhook,
                $request_body['task'],
                $request_body['done'],
                $done_at,
                $webhook->product_id,
                'Webhook'
            );

            return response()->json([
                'status' => 'success',
            ], 200);
        } elseif ($webhook->type === 'github' or $webhook->type === 'gitlab') {
            if ($request->header('X-GitHub-Event') === 'ping') {
                return response()->json([
                    'message' => 'Webhook Connected!',
                ], 200);
            }
            $request_body = $request->json()->all();

            if ($request->header('X-GitHub-Event') === 'push') {
                if (Str::contains($request_body['pusher']['name'], '[bot]')) {
                    return response()->json([
                        'message' => 'Bot cannot log tasks!',
                    ], 200);
                }
            } else {
                return response()->json([
                    'message' => 'Only push event is allowed!',
                ], 200);
            }
            if ($request_body['repository']['default_branch'] !== str_replace("refs/heads/", "", $request_body['ref'])) {
                return response()->json([
                    'message' => 'Only default branch is allowed!',
                ], 200);
            }

            if ($request_body['head_commit'] === 'None') {
                return response()->json([
                    'message' => 'No commits found!',
                ], 200);
            }

            if ($request_body['head_commit']) {
                $task = Str::limit($request_body['head_commit']['message'], 100);
            }

            $this->createTask(
                $webhook,
                $task,
                true,
                Carbon::now(),
                $webhook->product_id,
                $webhook->type === 'github' ? 'GitHub' : 'GitLab'
            );

            return response()->json([
                'status' => 'success',
            ], 200);
        }
    }

    public function newVersion($appkey)
    {
        if (env('APP_VERSION_KEY') === $appkey) {
            $client = new Client();
            $res = $client->request('POST', 'https://gitlab.com/api/graphql', [
                'form_params' => [
                    'query' => '
                    query {
                      project(fullPath: "taskord/taskord") {
                        releases(first: 1) {
                          nodes {
                            tagName
                            description
                          }
                        }
                      }
                    }',
                ],
            ]);
            $message = json_decode($res->getBody(), true)['data']['project']['releases']['nodes'][0];
            $users = User::all();
            foreach ($users as $user) {
                $user->notify(new VersionReleased($message));
            }

            return response()->json([
                'status' => 'success',
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
            ], 500);
        }
    }
}
