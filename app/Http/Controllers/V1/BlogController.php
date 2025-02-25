<?php

namespace App\Http\Controllers\V1;

use App\Enums\V1\BlogStatus;
use App\Http\Requests\V1\StoreBlogRequest;
use App\Http\Requests\V1\UpdateBlogRequest;
use App\Models\Blog;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BlogResource;
use App\Http\Resources\V1\Collection\BlogCollection;
use App\Models\Theme;
use Illuminate\Http\Request;
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
    public function index(Request $request)
    {
        try {
            if($request->get('themes')){
                $themesArray=explode(",",$request->get('themes'));
                $blogs=Blog::active()->with(['user','themes','commentaires'])->whereHas('themes',function($query) use($themesArray){
                    $query->whereIn('titre',$themesArray);
                })->latest()->paginate(5);
                return response()->json(new BlogCollection($blogs),200);
            }
            $blogs=Blog::active()->with(['user','themes','commentaires'])->latest()->paginate(5);
            return response()->json(new BlogCollection($blogs),200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur Serveur','error'=>$e], 500);
        }
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
            $data['image'] = $request->file('image')->store('images','public');
        }

        DB::beginTransaction();
        try {
            $blog = Blog::create($data);
            $blog->themes()->sync($this->extractThemes($request->themes));
            DB::commit();
            return response()->json(new BlogResource($blog), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erreur lors de la creation du blog','error'=>$e], 500);
        }
    }

    /**
     * Mettre à jour la ressource spécifiée dans le stockage.
     *
     * @param \App\Http\Requests\V1\UpdateBlogRequest $request
     * @param \App\Models\Blog $blog
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreBlogRequest $request, Blog $blog)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($blog->image);
            $data['image'] = $request->file('image')->store('images','public');
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

    public function show(Blog $blog){
        $blog->vue++;
        $blog->save();
        return response()->json(new BlogResource($blog->load('user','themes','commentaires')),200);
    }

    /**
     * Supprimer la ressource spécifiée du stockage.
     *
     * @param \App\Models\Blog $blog
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Blog $blog)
    {
        $blog->update(['status',BlogStatus::DELETED->value]);
        $blog->delete();
        return response()->json(null, 204);
    }
}
