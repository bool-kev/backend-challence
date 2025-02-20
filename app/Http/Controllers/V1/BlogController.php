<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\V1\StoreBlogRequest;
use App\Http\Requests\V1\UpdateBlogRequest;
use App\Models\Blog;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BlogResource;
use App\Models\Theme;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Extraire les thèmes de la chaîne donnée.
     *
     * @param string $themes
     * @return array
     */
    private function extractThemes($themes)
    {
        if (empty($themes)) {
            return [];
        }

        $themes = explode(',', $themes);
        return array_map(function ($theme) {
            return (Theme::firstOrCreate(['titre' => $theme]))->id;
        }, $themes);
    }

    /**
     * Afficher une liste de la ressource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(new BlogResource(Blog::all()));
    }

    /**
     * Stocker une nouvelle ressource dans le stockage.
     *
     * @param \App\Http\Requests\V1\StoreBlogRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBlogRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images');
        }

        DB::beginTransaction();
        try {
            $blog = Blog::create($data);
            $blog->themes()->sync($this->extractThemes($request->themes));
            DB::commit();
            return response()->json(new BlogResource($blog), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create blog'], 500);
        }
    }

    /**
     * Mettre à jour la ressource spécifiée dans le stockage.
     *
     * @param \App\Http\Requests\V1\UpdateBlogRequest $request
     * @param \App\Models\Blog $blog
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            Storage::delete($blog->image);
            $data['image'] = $request->file('image')->store('images');
        }

        DB::beginTransaction();
        try {
            $blog->update($data);
            $blog->themes()->sync($this->extractThemes($request->themes));
            DB::commit();
            return response()->json(new BlogResource($blog), 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update blog'], 500);
        }
    }

    /**
     * Supprimer la ressource spécifiée du stockage.
     *
     * @param \App\Models\Blog $blog
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Blog $blog)
    {
        $blog->update(['status','deleted']);
        $blog->delete();
        return response()->json(null, 204);
    }
}
