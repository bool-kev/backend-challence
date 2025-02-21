<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Request $request,Blog $blog)
    {
        $user=$request->user();
        $like=$blog->likes()->toggle([$user->id]);
        return response()->json(['like'=>$like]);
    }
}
