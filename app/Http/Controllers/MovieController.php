<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Movie::paginate(8);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {}
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'movie_title' => 'required|string|max:255',
            'grid_img' => 'required|file|mimes:jpg,jpeg,png|max:10240',
            'banner_img' => 'required|file|mimes:jpg,jpeg,png|max:10240',
            'genre' => 'required|string|max:15',
            'rating' => 'required|numeric|max:8',
            'release_date' => 'required|date',
            'category' => 'required|string|max:15',
            'IMDb_link' => 'required|string'
        ]);

        try {
            $grid_img_url = $this->handleFileUpload($request->file('grid_img'));
            $banner_img_url = $this->handleFileUpload($request->file('banner_img'));

            $movie = Movie::create([
                'movie_title' => $request->input('movie_title'),
                'grid_img' => $grid_img_url,
                'banner_img' => $banner_img_url,
                'genre' => $request->input('genre'),
                'rating' => $request->input('rating'),
                'release_date' => $request->input('release_date'),
                'category' => $request->input('category'),
                'IMDb_link' => $request->input('IMDb_link')
            ]);
            return response()->json([
                'message' => 'Movie Created Successfully',
                'success' => true,
                'data' => $movie
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create movie',
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json([
                'message' => 'Movie not found',
                'success' => false,
            ]);
        }

        return response()->json([
            'message' => 'Movie found successfully',
            'success' => true,
            'data' => $movie
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        $request->validate([
            'movie_title' => 'required|string|max:255',
            'grid_img' => 'nullable|file|mimes:jpg,jpeg,png|max:10240', // Max 10MB
            'banner_img' => 'nullable|file|mimes:jpg,jpeg,png|max:10240', // Max 10MB
            'genre' => 'required|string|max:15',
            'rating' => 'required|numeric|max:8',
            'release_date' => 'required|date',
            'category' => 'required|string|max:15',
            'IMDb_link' => 'required|string',
            'grid_img_file_path' => 'required_unless:grid_img,null',
            'banner_img_file_path' => 'required_unless:banner_img,null'
        ]);

        try {
            $this->updateImage('grid_img', 'grid_img_file_path', $movie, $request);
            $this->updateImage('banner_img', 'banner_img_file_path', $movie, $request);

            $movie->movie_title = $request->input('movie_title');
            $movie->genre = $request->input('genre');
            $movie->rating = $request->input('rating');
            $movie->release_date = $request->input('release_date');
            $movie->category = $request->input('category');
            $movie->IMDb_link = $request->input('IMDb_link');

            $movie->save();

            return response()->json([
                'message' => 'Movie updated successfully',
                'success' => true,
                'data' => $movie
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update movie',
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        try {
            File::delete($movie->grid_img);
            File::delete($movie->banner_img);

            $movie->delete();

            return response()->json([
                'message' => 'Movie deleted successfully',
                'success' => true,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete movie',
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }


    protected function handleFileUpload($img)
    {
        if ($img && $img->isValid()) {
            // Generate unique filename
            $t = time();
            $rnd = random_int(1111, 999999);
            $img_file_name = $img->getClientOriginalName();
            $image_name = "{$t}-{$rnd}-{$img_file_name}";

            // Define the upload directory path
            $uploadPath = 'uploads';
            $this->ensureUploadDirectoryExists($uploadPath);

            // Move the file to the public directory
            $img->move(public_path($uploadPath), $image_name);

            // Return the file URL
            // return asset("$uploadPath/$image_name"); //full path
            return "$uploadPath/$image_name"; //image name
        }

        throw new Exception("Invalid file upload");
    }
    protected function ensureUploadDirectoryExists($path)
    {
        $fullPath = public_path($path);
        if (!file_exists($fullPath)) {
            if (!mkdir($fullPath, 0755, true)) {
                throw new Exception("Failed to create directory: {$fullPath}");
            }
        }
    }
    protected function updateImage($imageField, $imagePathField, Movie $movie, Request $request)
    {
        if ($request->hasFile($imageField)) {
            $image_url = $this->handleFileUpload($request->file($imageField));
            $movie->$imageField = $image_url; // Update the image URL

            // Delete old image if it exists
            $oldImagePath = $request->input($imagePathField);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }
    }
}
