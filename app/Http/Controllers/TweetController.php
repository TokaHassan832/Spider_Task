<?php

namespace App\Http\Controllers;

use App\Http\Requests\TweetRequest;
use App\Http\Resources\TweetResource;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{
    public function create(TweetRequest $request): TweetResource
    {
        $tweet = Tweet::create([
            'user_id' => Auth::id(),
            'content' => $request->validated('tweet'),
        ]);

        return (new TweetResource($tweet))->additional([
            'message' => __('auth.tweet_success')
        ]);
    }

    public function timeline(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $user = Auth::user();

        $followedUserIds = $user->follows()->pluck('followed_id');

        if ($followedUserIds->isEmpty()) {
            return TweetResource::collection(collect([]))->additional([
                'message' => __('auth.no_tweets_found')
            ]);
        }

        $tweets = Tweet::whereIn('user_id', $followedUserIds)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return TweetResource::collection($tweets);
    }

}
