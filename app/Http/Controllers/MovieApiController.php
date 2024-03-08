<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use Illuminate\Support\Facades\Storage;

class MovieApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movie::paginate(10);
        return response()->json([
            'data' => $movies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request)
    {
        $movie = Movie::create([
            'name' => $request->name,
            'duration' => $request->duration,
            'synopsis' => $request->synopsis,
            'year' => $request->year,
            'image' => $request->image
        ]);

        if ($request->file('image')) {
            $validated['image'] = $request->file('image')->store('movie_image');
        }
        return response()->json([
            'data' => $movie
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        return response()->json([
            'data' => $movie
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        $movie->name = $request->name;
        $movie->duration = $request->duration;
        $movie->synopsis = $request->synopsis;
        $movie->year = $request->year;
        $movie->image = $request->image;

        if ($request->file('image')) {
            if ($movie->image) {
                Storage::delete($movie->image);
            }
            $validated['image'] = $request->file('image')->store('movie_image');
        }

        $movie->save();

        return response()->json([
            'data' => $movie
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return response()->json([
            'message' => 'Successfully Delete Movie'
        ], 204);
    }
}
