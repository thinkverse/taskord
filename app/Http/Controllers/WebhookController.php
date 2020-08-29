<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Webhook;
use Carbon\Carbon;
use GrahamCampbell\Throttle\Facades\Throttle;
use Illuminate\Http\Request as WebhookRequest;
use Illuminate\Support\Facades\Request;

class WebhookController extends Controller
{
    public function createTask($webhook, $task, $done, $done_at, $type)
    {
        $task = Task::create([
            'user_id' =>  $webhook->user_id,
            'task' => $task,
            'done' => $done,
            'done_at' => $done_at,
            'type' => 'user',
            'source' => $type,
        ]);
    }
    
    public function web($token, WebhookRequest $request)
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (! $throttler->check()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Your are rate limited, try again later!',
            ]);
        }

        $webhook = Webhook::where('token', $token)->first();
        if (! $webhook) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No webhook exists',
            ]);
        }
        
        if (User::find($webhook->user_id)->isFlagged) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Your account is flagged!',
            ]);
        }
        
        if ($webhook->type === 'web') {
            $request_body = $request->json()->all();
            if (
                ! array_key_exists('task', $request_body) or
                ! array_key_exists('done', $request_body)
            ) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Invalid parameters',
                ]);
            }
            if ($request_body['done']) {
                $done_at = Carbon::now();
            } else {
                $done_at = null;
            }
            
            $this->createTask
            (
                $webhook,
                $request_body['task'],
                $request_body['done'],
                $done_at,
                'Webhook'
            );

            return response()->json([
                'status' => 'success',
            ]);
        } elseif ($webhook->type === 'github') {
            $request_body = $request->json()->all();
            if (count($request_body['commits']) === 1) {
                $task = $request_body['commits'][0]['message']. ' on '.$request_body['repository']['name'];
            } else {
                $task = 'Pushed '.count($request_body['commits']).' changes to '.$request_body['repository']['name'];
            }
            
            $this->createTask
            (
                $webhook,
                $task,
                true,
                Carbon::now(),
                'GitHub'
            );

            return response()->json([
                'status' => 'success',
            ]);
        }
    }
}
