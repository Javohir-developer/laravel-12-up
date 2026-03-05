<?php
namespace App\Repositories\Api\Movies;

use App\Models\Movie;
use App\Models\Status;

class MovieRepository
{
    public function getAll(array $filters = [])
    {
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
