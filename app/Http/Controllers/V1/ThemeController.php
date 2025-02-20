<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ThemeRequest;
use App\Http\Resources\V1\ThemeCollection;
use App\Http\Resources\V1\ThemeResource;
use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ThemeCollection(Theme::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ThemeRequest $request)
    {
        $request->validated(); 
        $theme = Theme::create($request->only('titre'));
        return response()->json(new ThemeResource($theme), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Theme $theme)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Theme $theme)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ThemeRequest $request, Theme $theme)
    {
        $request->validated();
        $theme->update($request->only('titre'));
        return response()->json(new ThemeResource($theme), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theme $theme)
    {
        $theme->delete();
        return response()->json(null, 204);
    }
}
