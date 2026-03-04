<?php
namespace App\Repositories\Movies;

use App\Models\Movies\Movie;
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

    public function createMovies(array $data)
    {
        return Movie::create($data);
    }

    public function update($id, array $data)
    {
        $movie = Movie::findOrFail($id);
        $movie->update($data);
        return $movie;
    }

    public function delete($id)
    {
        return Movie::destroy($id);
    }

    public function getById($id)
    {
        return Movie::findOrFail($id);
    }

    public function getStatus()
    {
        return Status::select('id', 'name')->get();
    }
}
