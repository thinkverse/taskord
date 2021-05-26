<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    public function profile($username)
    {
        $user = User::withCount(['questions', 'answers', 'milestones'])
            ->whereUsername($username)->firstOrFail();
        $type = Route::current()->getName();

        $response = [
            'user' => $user,
            'type' => $type,
            'level' => $user->badges->sortBy(function ($post) {
                return $post->pivot->created_at;
            }),
            'done_count' => $user->tasks()->whereDone(true)->count('id'),
            'pending_count' => $user->tasks()->whereDone(false)->count('id'),
            'product_count' => $user->ownedProducts()->count('id'),
            'question_count' => $user->questions_count,
            'answer_count' => $user->answers_count,
            'milestone_count' => $user->milestones_count,
        ];

        if (auth()->check() && auth()->user()->id === $user->id or auth()->check() && auth()->user()->staff_mode) {
            return view($type, $response);
        } elseif ($user->spammy) {
            abort(404);
        }

        return view($type, $response);
    }

    public function profileSettings()
    {
        return view('user.settings.profile', [
            'user' => auth()->user(),
        ]);
    }

    public function appearanceSettings()
    {
        return view('user.settings.appearance', [
            'user' => auth()->user(),
        ]);
    }

    public function accountSettings()
    {
        return view('user.settings.account', [
            'user' => auth()->user(),
        ]);
    }

    public function productsSettings()
    {
        return view('user.settings.products', [
            'user' => auth()->user(),
        ]);
    }

    public function patronSettings()
    {
        return view('user.settings.patron', [
            'user' => auth()->user(),
        ]);
    }

    public function passwordSettings()
    {
        return view('user.settings.password', [
            'user' => auth()->user(),
        ]);
    }

    public function notificationsSettings()
    {
        return view('user.settings.notifications', [
            'user' => auth()->user(),
        ]);
    }

    public function exportAccount()
    {
        if (auth()->check()) {
            $account = User::find(auth()->user()->id);
            $data = collect([
                'account' => $account,
                'followings' => $account->followings()->get(),
                'followers' => $account->followers()->get(),
                'tasks' => $account->tasks()->get(),
                'comments' => $account->comments()->get(),
                'products' => $account->ownedProducts()->get(),
                'product_updates' => $account->productUpdates()->get(),
                'questions' => $account->questions()->get(),
                'answers' => $account->answers()->get(),
                'milestones' => $account->milestones()->get(),
                'patron' => $account->patron()->get(),
            ])->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            $fileName = carbon()->format('d_m_Y_h_i_s').'_'.$account->username.'_data.json';
            $response = response($data, 200, [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
            ]);
            loggy(request(), 'User', auth()->user(), 'Exported the account data');

            return $response;
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function exportLogs()
    {
        if (auth()->check()) {
            $logs = Activity::causedBy(auth()->user())
                ->get();
            $data = collect([
                'logs' => $logs,
            ])->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            $fileName = carbon()->format('d_m_Y_h_i_s').'_'.auth()->user()->username.'_logs.json';
            $response = response($data, 200, [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
            ]);
            loggy(request(), 'User', auth()->user(), 'Exported the account logs');

            return $response;
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function integrationsSettings()
    {
        return view('user.settings.integrations', [
            'user' => auth()->user(),
        ]);
    }

    public function apiSettings()
    {
        return view('user.settings.api', [
            'user' => auth()->user(),
        ]);
    }

    public function logsSettings()
    {
        return view('user.settings.logs', [
            'user' => auth()->user(),
        ]);
    }

    public function dataSettings()
    {
        return view('user.settings.data', [
            'user' => auth()->user(),
        ]);
    }

    public function deleteSettings()
    {
        return view('user.settings.delete', [
            'user' => auth()->user(),
        ]);
    }

    public function avatar($username)
    {
        $avatar = User::whereUsername($username)->first();

        return redirect($avatar->avatar);
    }

    public function mention(Request $request)
    {
        if ($request['query']) {
            $users = User::select('username', 'firstname', 'lastname', 'avatar', 'is_verified')
                ->search($request['query'])
                ->take(10)
                ->get();
        } else {
            $users = '';
        }

        return $users;
    }

    public function popover(User $user)
    {
        return view('user.popover', [
            'user' => $user,
        ]);
    }

    public function darkMode()
    {
        if (auth()->user()->dark_mode) {
            auth()->user()->dark_mode = false;
            auth()->user()->save();
            loggy(request(), 'User', auth()->user(), 'Disabled dark mode');

            return response()->json([
                'status' => 'disabled',
            ]);
        } else {
            auth()->user()->dark_mode = true;
            auth()->user()->save();
            loggy(request(), 'User', auth()->user(), 'Enabled dark mode');

            return response()->json([
                'status' => 'enabled',
            ]);
        }
    }
}
