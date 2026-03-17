<?php

namespace App\Http\Controllers\Api;

use App\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;

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
        $reviews=Review::with('user','product')->get();
        if($reviews->isEmpty()){
            return $this->error('No Found Any Reviews',200);
        }
        return $this->success('This is All Reviews',200,ReviewResource::collection($reviews));
    }
}
