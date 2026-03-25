<?php
namespace Modules\Api\Services\Movies;

use App\Models\Movie;

class MovieService
{
    public function getAllMovies($request)
    {
        $filters = $request->only(['id', 'title']);
        $query = Movie::query();

        if (!empty($filters['id'])) {
            $query->where('id', $filters['id']);
        }

        if (!empty($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        return $query->paginate(10);
    }
}
