<?php
namespace App\Repositories\Movies;

use App\Models\Movies\Movie;
use App\Models\Status;

class MovieRepository
{
    public function getAll()
    {
        return Movie::all();
    }
    public function getByFilters($request)
    {
        $query =  Movie::query();

        if (!empty($request->id)) {
            $query->where('id', $request->id);
        }

        if (!empty($request->title)) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        return $query->paginate()->all();
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
