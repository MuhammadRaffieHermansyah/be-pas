<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator as validator;


class MovieApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movie::paginate(100);
        // $movies->image = asset('movie_image/' , $movies->name);
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
        $validated = $request->validate([
            'name' => 'required|max:255',
            'duration' => 'required',
            'synopsis' => 'required',
            'image' => 'image|file|max:6240',
            'year' => 'required',
        ]);

        // $validator = validator::make($request->all(), [
        //     'name' => 'required|max:255',
        //     'duration' => 'required',
        //     'synopsis' => 'required',
        //     'image' => 'image|file|max:6240',
        //     'year' => 'required',
        // ]);

        if($request->file('image')){
            $validated['image'] = $request->file('image')->store('movie-images');
        }
        $movie = Movie::create($validated);
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
        // $validator = validator::make($request->all(), [
        //     'name' => 'required|max:255',
        //     'duration' => 'required',
        //     'synopsis' => 'required',
        //     'image' => 'image|file|max:6240',
        //     'year' => 'required',
        // ]);
        $validated = $request->validate([
            'name' => 'required|max:255',
            'duration' => 'required',
            'synopsis' => 'required',
            'image' => 'image|file|max:6240',
            'year' => 'required',
        ]);
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }
        if($request->file('image')){
            if($movie->image){
                Storage::delete($movie->image);
            }
            $validated['image'] = $request->file('image')->store('movie_image');
        }

        $movie = Movie::where('id', $movie->id)
            ->update($validated);
        return response()->json([
            'data' => $movie
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        if ($movie->image) {
            Storage::delete($movie->image);
        }

        Movie::destroy($movie->id);
        return response()->json([
            'message' => 'Successfully Delete Movie'
        ] , 204);
    }
}
