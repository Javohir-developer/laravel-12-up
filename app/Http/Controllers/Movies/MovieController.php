<?php
namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use App\Http\Requests\Movies\MovieRequest;
use App\Services\Movies\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

//    public function index(Request $request)
//    {
//        $movies = $this->movieService->getAllMovies();
//        return view('movies.index', compact('movies'));
//    }
//
//    public function create()
//    {
//        return view('movies.create');
//    }
//
//    public function store(MovieRequest $request)
//    {
//        $this->movieService->createMovies($request->validated());
//        return redirect()->route('movies.index');
//    }
//
//
//    public function update(MovieRequest $request, $id)
//    {
//        $movie = $this->movieService->updateMovies($id, $request->validated());
//        return redirect()->route('movies.index')
//            ->with('success', 'Movie updated successfully')
//            ->with('updatedMovie', $movie);
//    }
//
//    public function show($id)
//    {
//        $movie = $this->movieService->getMoviesById($id);
//
//        if (!$movie) {
//            return abort(404, 'Movie not found');
//        }
//
//        return view('movies.show', compact('movie'));
//    }
//



    public function test(Request $request)
    {
        $searchParam = $request->query();
        return response()->json($searchParam);
    }

    public function index(Request $request)
    {
        $request = $this->movieService->getFilteredMovies($request);
        return response()->json($request);
    }

    public function createMovies(MovieRequest $request)
    {
        $request = $this->movieService->createMovies($request->validated());
        return response()->json($request);
    }

    public function getStatus()
    {
        $request = $this->movieService->getStatus();
        return response()->json($request);
    }
}
