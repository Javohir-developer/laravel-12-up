<?php
namespace App\Services\App\Movies;

use App\Jobs\AddComment;
use App\Jobs\SendEmailJob;
use App\Models\Movies\Movie;
use App\Repositories\App\Movies\MovieRepository;
use App\Services\Common\FileUploadService;
use Illuminate\Http\Request;

class MovieService
{

    public function __construct(
        private MovieRepository $movieRepository,
        private FileUploadService $fileUploadService
    ) {}

    public function getAllMovies($request)
    {
        $filters = $request->only(['id', 'title']);
        return $this->movieRepository->getAll($filters);
    }

    public function createMovies(array $data)
    {
        if (isset($data['image'])) {
            $data['image'] = $this->fileUploadService->upload($data['image']);
        }
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
