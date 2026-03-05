<?php

namespace App\Http\Controllers\Api\v1\Movie;

use App\Http\Controllers\Api\v1\Controller;
use App\Http\Requests\Movies\MovieRequest;
use App\Services\Movies\MovieService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MovieApiController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['id', 'title']);
        $movies = $this->movieService->getAllMovies($filters);

        return response()->json([
            'success' => true,
            'data' => $movies
        ]);
    }

    public function store(MovieRequest $request): JsonResponse
    {
        $movie = $this->movieService->createMovies($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Movie created successfully',
            'data' => $movie
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $movie = $this->movieService->getMoviesById($id);

        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Movie not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $movie
        ]);
    }

    public function update(MovieRequest $request, $id): JsonResponse
    {
        $movie = $this->movieService->updateMovies($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Movie updated successfully',
            'data' => $movie
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $this->movieService->deleteMovies($id);

        return response()->json([
            'success' => true,
            'message' => 'Movie deleted successfully'
        ]);
    }
}
