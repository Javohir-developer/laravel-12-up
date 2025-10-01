<?php

namespace App\Jobs;

use App\Models\Movies\Movie;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddComment implements ShouldQueue
{
    use Queueable;
    public $title;
    public $id;
    /**
     * Create a new job instance.
     */
    public $tries = 3;
    public function __construct(string $title, int $id)
    {
        $this->title = $title;
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $movie = Movie::find($this->id);

        if (!$movie) {
            Log::error("Movie topilmadi: ID = {$this->id}");
            return;
        }

        $movie->comment = 'navbat ishga tushdi';
        $movie->save();

        Log::info("Movie comment yangilandi. ID = {$this->id}");
    }
}
