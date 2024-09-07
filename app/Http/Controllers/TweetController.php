<?php

namespace App\Http\Controllers;

use App\Http\Requests\TweetRequest;
use App\Http\Resources\TweetResource;
use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function create(TweetRequest $request): TweetResource
    {
        $tweet = Tweet::create([
            'user_id' => auth()->id(),
            'content' => $request->tweet,
        ]);

        return new TweetResource($tweet);
    }

    public function timeline(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $user = auth()->user();

        $followedUserIds = $user->follows()->pluck('followed_id');

        if ($followedUserIds->isEmpty()) {
            return TweetResource::collection(collect([]));
        }

        $tweets = Tweet::whereIn('user_id', $followedUserIds)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return TweetResource::collection($tweets);
    }

}
