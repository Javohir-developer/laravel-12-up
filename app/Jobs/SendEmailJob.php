<?php

namespace App\Jobs;

use App\Models\Movies\Movie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
// use Mail yoki boshqa service
use Illuminate\Support\Facades\Mail;
//use App\Mail\SimpleMail; // agar mailable ishlatsangiz

class SendEmailJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public $title;
    public $id;

    // retry xatolikda qayta urinishi uchun
    public $tries = 3;

    public function __construct(string $title, int $id)
    {
        $this->title = $title;
        $this->id = $id;
    }

    public function handle()
    {
        // Bu yerda haqiqiy ish: masalan email yuborish
//        DB::update('UPDATE movies SET comment = ? WHERE id = ?', ['Yangi comment', 20]);

        $post = Movie::find($this->id);

        if (!$post) {
            Log::error("Movie with ID {$this->id} not found.");
            return;
        }

        $post->update([
            'comment' => $this->title . ' navbat ishga tushdi'
        ]);

        Log::info("Movie ID {$this->id} yangilandi: comment qo'shildi.");
    }

    public function failed(\Throwable $exception)
    {
        // Job 3 marta urinishdan keyin ham muvaffaqiyatsiz bo'lsa chaqiriladi.
        // logging, alert yoki boshqa fallback ni shu yerga yozing.
        Log::error('SendEmailJob failed: ' . $exception->getMessage());
    }
}
