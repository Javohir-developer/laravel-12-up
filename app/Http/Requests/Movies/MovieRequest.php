<?php

namespace App\Http\Requests\Movies;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
{

    public function authorize()
    {
        return true; // Hamma uchun ruxsat berish
    }

    public function rules()
    {
        $routeName = $this->route()->getName(); // Hozirgi route nomini olish

        // Agar create bo‘lsa
        if ($this->isMethod('post')) {
            return [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'release_year' => 'required|integer',
                'rating' => 'required|integer'
            ];
        }

        // Agar update bo‘lsa
//        if ($this->isMethod('put') && $routeName === 'movies.update') {
//            return [
//                'title' => 'sometimes|required|string|max:255',
//                'description' => 'nullable|string',
//                'release_year' => 'sometimes|required|integer|min:1900|max:' . date('Y'),
//                'rating' => 'sometimes|required|numeric|min:0|max:10',
//            ];
//        }

        return [];
    }
}
