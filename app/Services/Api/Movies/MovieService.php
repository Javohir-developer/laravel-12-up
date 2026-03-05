<?php
namespace App\Services\Api\Movies;

use App\Repositories\Api\Movies\MovieRepository;

class MovieService
{

    public function __construct(private MovieRepository $movieRepository) {}

    public function getAllMovies($request)
    {
        $filters = $request->only(['id', 'title']);
        return $this->movieRepository->getAll($filters);
    }
}
