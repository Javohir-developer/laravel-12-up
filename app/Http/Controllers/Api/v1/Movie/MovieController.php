<?php

namespace App\Http\Controllers\Api\v1\Movie;

use App\Http\Controllers\Api\v1\Controller;
use App\Services\Api\Movies\MovieService;
use App\Resources\Movies\MovieResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
    public function __construct(private MovieService $movieService) {}

    public function index(Request $request): JsonResponse
    {
        $movies = $this->movieService->getAllMovies($request);
        return $this->sendResponse(
            MovieResource::collection($movies)
        );
    }

}
