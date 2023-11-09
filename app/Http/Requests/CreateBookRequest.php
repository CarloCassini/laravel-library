<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string'],
            'author' => ['required', 'string'],
            'editor' => ['required', 'string'],
            'synopsis' => ['required', 'string'],
            'genre_id' => ['nullable', 'integer', 'exists:genres,id'],
            'published' => ['required'],
            'pages' => ['required', 'integer'],
            'typologies' => ['nullable', 'exists:typologies,id'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Titolo necessario',
            'author.required' => 'Autore necessario',
            'editor.required' => 'Editore necessario',
            'synopsis.required' => 'Sinossi necessaria',
            'published.required' => 'Data di pubblicazione necessarie',
            'pages.required' => 'Numero pagine necessario',

            'title.string' => 'Titolo deve essere una stringa',
            'author.string' => 'Autore deve essere una string',
            'editor.string' => 'Editore deve essere una stringa',
            'synopsis.string' => 'La sinossi deve essere una stringa',
            'pages.integer' => 'Numero pagine deve essere un numero',

            'genre.integer' => 'Il Genere inserito non è valido',
            'genre.exists' => 'Il genere non è valido',

            'typologies.exists' => 'la tipologia scelta non è contemplata',
        ];
    }
}