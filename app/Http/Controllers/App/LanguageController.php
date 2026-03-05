<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\App\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switchLang($locale)
    {
        $supportedLocales = ['uz', 'ru', 'en'];
        
        if (in_array($locale, $supportedLocales)) {
            session()->put('locale', $locale);
        }
        
        return back();
    }
}
