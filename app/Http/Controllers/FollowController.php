<?php

namespace App\Http\Controllers;

use App\Events\FollowedUserEvent;
use App\Models\User;
use App\Notifications\UserFollowed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class FollowController extends Controller
{
    public function follow(User $user): \Illuminate\Http\JsonResponse
    {
        $follower = Auth::user();

        if ($follower->id === $user->id) {
            return response()->json(['error' =>  __('follow.cannot_follow_self')], 403);
        }

        if ($follower->isFollowing($user)) {
            return response()->json(['error' =>  __('follow.already_following')], 400);
        }

        $follower->follows()->attach($user->id);

        Notification::send($user, new UserFollowed($follower));

        event(new FollowedUserEvent($follower));


        return response()->json(['message' =>  __('follow.success_follow')], 200);
    }
}
