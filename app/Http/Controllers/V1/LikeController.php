<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Request $request,Blog $blog)
    {
        $user=$request->user();
        $like=$blog->likes()->toggle([$user->id]);
        return response()->json(new BlogResource($blog->refresh()->load(['user','themes','likes'])), 200);
    }
}
