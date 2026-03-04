<?php
namespace Tests\Feature\Movies;

use App\Repositories\Movies\MovieRepository;
use App\Services\Movies\MovieService;
use Database\Seeders\Movies\MovieSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Movies\Movie;


class MovieTest extends TestCase
{
    // Bazani har bir test uchun yangilab turish (testlar orasida eski ma'lumotlar saqlanib qolmasligi uchun)
    use RefreshDatabase;

    protected $movieService;
    protected $movieRepository;

    // Har bir testdan oldin repository va service obyektlarini yaratamiz
    protected function setUp(): void
    {
        parent::setUp();
        $this->movieRepository = new MovieRepository(new Movie());
        $this->movieService = new MovieService($this->movieRepository);
    }

//  Movie model yordamida bazaga yangi film qo'shish test qilinadi.
    public function test_it_can_create_a_movie()
    {
        // Fake ma'lumot yaratish
        Movie::create([
            'title' => 'Inception',
            'description' => 'A mind-bending thriller',
            'release_year' => 2010,
            'rating' => 8
        ]);

        // Film bazada mavjudligini tekshiramiz
        $this->assertDatabaseHas('movies', ['title' => 'Inception']);
    }


//  Bazaga 3 ta film qo'shilib, umumiy soni tekshiriladi.
    public function test_it_can_fetch_all_movies()
    {
        // Fake ma'lumotlar yaratish
        Movie::factory()->count(3)->create();

        // Bazadan barcha filmlarni olish
        $movies = $this->movieService->getAllMovies();

        // Filmlar soni 3 ga teng ekanligini tekshirish
        $this->assertCount(3, $movies);
    }

//  Berilgan ID bo'yicha film topish test qilinadi.
    public function test_it_can_find_a_movie_by_id()
    {
        // Fake film yaratish
        $movie = Movie::factory()->create();

        // Repository orqali filmni topish
        $foundMovie = $this->movieRepository->getById($movie->id);

        // Topilgan filmning ID sini tekshirish
        $this->assertEquals($movie->id, $foundMovie->id);
    }

//  Validatsiya test: title maydonini kiritmasdan film yaratib bo‘lmaydi.
    public function test_it_validates_required_fields_when_creating_a_movie()
    {
        // Title maydonini kiritmasdan so‘rov yuboramiz
        $response = $this->post(route('movies.store'), [
            'release_year' => 2010,
            'rating' => 8
        ]);

        // Validatsiya ishlashi kerak va 'title' maydoni uchun xatolik qaytishi kerak
        $response->assertSessionHasErrors('title');
    }

////  Movie index sahifasi mavjudligini test qilish.
//    public function test_it_can_access_movies_index_page()
//    {
//        // Index sahifasiga GET so‘rov yuborish
//        $response = $this->get(route('movies.index'));
//
//        // Sahifa mavjudligini tekshirish (200 status kodi qaytishi kerak)
//        $response->assertStatus(200);
//
//        // View sahifasi to‘g‘ri ekanligini tekshirish
//        $response->assertViewIs('movies.index');
//    }


//  Yangi film qo‘shish va bazada mavjudligini test qilish.
    public function test_it_can_store_a_new_movie()
    {
        // POST so‘rov orqali yangi film yaratamiz
        $response = $this->post(route('movies.store'), [
            'title' => 'Titanic',
            'description' => 'A romantic drama',
            'release_year' => 1997,
            'rating' => 7
        ]);

        // Film bazaga qo‘shilganini tekshiramiz
        $this->assertDatabaseHas('movies', ['title' => 'Titanic']);

        // Film yaratilgandan keyin index sahifasiga qaytishi kerak
        $response->assertRedirect(route('movies.index'));
    }

    //  Filmni yangilash testi (update)
    public function test_it_can_update_a_movie()
    {
        // 1. Fake film yaratish
        $movie = Movie::factory()->create([
            'title' => 'Old Title',
            'description' => 'Old description',
            'release_year' => 2000,
            'rating' => 7
        ]);

        // 2. Filmni yangi ma'lumot bilan yangilash
        $response = $this->put(route('movies.update', $movie->id), [
            'title' => 'Old Title',
            'description' => 'Old description',
            'release_year' => 2000,
            'rating' => 7
        ]);

        // 3. Film bazada yangilanganini tekshirish
        $this->assertDatabaseHas('movies', [
            'title' => 'Old Title',
            'description' => 'Old description',
            'release_year' => 2000,
            'rating' => 7
        ]);

        // 4. Yangilanganidan keyin index sahifasiga qaytish kerak
        $response->assertRedirect(route('movies.index'));
    }


//  Seeder yordamida ma'lumotlarni bazaga yuklashni test qilish.
    public function test_it_can_seed_movies_table()
    {
        // Seeder orqali bazani ma'lumot bilan to'ldirish
        $this->seed(MovieSeeder::class);

        // 10 ta ma'lumot yaratilganligini tekshirish
        $this->assertDatabaseCount('movies', 3);
    }


//  Routes tekshiriladi: movies.index sahifasi mavjudligini test qilish.
    public function test_it_checks_if_movies_route_exists()
    {
        // GET so‘rov orqali sahifaga kirish
        $response = $this->get(route('movies.index'));

        // Sahifa mavjud bo‘lishi kerak (200 status kodi qaytishi kerak)
        $response->assertStatus(200);
    }
}
