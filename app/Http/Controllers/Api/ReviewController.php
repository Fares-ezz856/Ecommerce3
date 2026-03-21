<?php

namespace App\Http\Controllers\Api;

use App\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Support\Facades\Cache;

class ReviewController extends Controller
{
    use ApiResponse;
    public function create(ReviewRequest $reviewRequest){
        $validated=$reviewRequest->validated();
        $validated['user_id']=auth('user')->id();
        Review::create($validated);
        return $this->success('Review Added Successfully');
    }

    public function all(){
        if(!Cache::has('reviews')){
            $reviews=Review::with('user','product')->get();
            Cache::remember('reviews',now()->addDay(),function() use ($reviews){
                return $reviews;
            });
        }
        $reviews=Cache::get('reviews');
        // Cache::forget('reviews');

        if($reviews->isEmpty()){
            return $this->error('No Found Any Reviews',200);
        }
        return $this->success('This is All Reviews',200,ReviewResource::collection($reviews));
    }
}
