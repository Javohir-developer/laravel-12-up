<?php
namespace App\Services\Movies;

use App\Jobs\AddComment;
use App\Jobs\SendEmailJob;
use App\Models\Movies\Movie;
use App\Repositories\Movies\MovieRepository;
use Illuminate\Http\Request;

class MovieService
{

    protected $movieRepository;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function getAllMovies(array $filters = [])
    {
        return $this->movieRepository->getAll($filters);
    }

    public function createMovies(array $data)
    {
        $movieRepository = $this->movieRepository->createMovies($data);
//        dispatch(new AddComment($movieRepository->title, $movieRepository->id));
        return $movieRepository;
    }

    public function updateMovies($id, array $data)
    {
        // Logika qo‘shish mumkin (masalan, shartlar, validatsiya, eventlar)
        return $this->movieRepository->update($id, $data);
    }

    public function getMoviesById($id)
    {
        return $this->movieRepository->getById($id);
    }

    public function getStatus()
    {
        return $this->movieRepository->getStatus();
    }

    public function deleteMovies($id)
    {
        return $this->movieRepository->delete($id);
    }
}
