<?php

namespace Modules\Api\Http\Controllers\V1\Movie;

use Modules\Api\Http\Controllers\BaseApiController;
use Modules\Api\Services\Movies\MovieService;
use Modules\Api\Resources\Movies\MovieResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MovieController extends BaseApiController
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
