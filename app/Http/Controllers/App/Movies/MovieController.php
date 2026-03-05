<?php
namespace App\Http\Controllers\App\Movies;

use App\Http\Controllers\App\Controller;
use App\Http\Requests\Movies\MovieRequest;
use App\Services\App\Movies\MovieService;
use App\Services\ElasticsearchService\ElasticsearchService;
use Illuminate\Http\Request;
use Inertia\Inertia;
class MovieController extends Controller
{
    public function __construct(private MovieService $movieService) {}

    public function index(Request $request)
    {
        $movies = $this->movieService->getAllMovies($request);
        return Inertia::render('Movies/Index', [
            'movie' => $movies,
            'filters' => $request->only(['id', 'title'])
        ]);
    }

    public function create()
    {
        $options = $this->movieService->getStatus();
        return Inertia::render('Movies/Create', [
            'options' => $options
        ]);
    }

    public function store(MovieRequest $request)
    {
        $this->movieService->createMovies($request->validated());
        return redirect()->route('movie.index');
    }

    public function edit($id)
    {
        $movie = $this->movieService->getMoviesById($id);
        $options = $this->movieService->getStatus();
        
        if (!$movie) {
            return redirect()->route('movie.index')->with('error', 'Movie not found');
        }
        
        return Inertia::render('Movies/Edit', [
            'movie' => $movie,
            'options' => $options
        ]);
    }


    public function update(MovieRequest $request, $id)
    {
        $movie = $this->movieService->updateMovies($id, $request->validated());
        return redirect()->route('movie.index')
            ->with('success', 'Movie updated successfully')
            ->with('updatedMovie', $movie);
    }

    public function show($id)
    {
        $movie = $this->movieService->getMoviesById($id);

        if (!$movie) {
            return abort(404, 'Movie not found');
        }

        return view('movies.show', compact('movie'));
    }


    // public function test(Request $request)
    // {
    //     return Inertia::render('movies/index', [
    //         'test' => session('test'),
    //         // 'response' => $response,
    //     ]);
    // }
}
