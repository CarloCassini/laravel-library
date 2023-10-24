<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'genre' => ['required', 'string'],
            'published' => ['required'],
            'pages' => ['required', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Titolo necessario',
            'author.required' => 'Autore necessario',
            'editor.required' => 'Editore necessario',
            'genre.required' => 'Genere necessario',
            'published.required' => 'Data di pubblicazione necessarie',
            'pages.required' => 'Numero pagine necessario',

            'title.string' => 'Titolo deve essere una stringa',
            'author.string' => 'Autore deve essere una string',
            'editor.string' => 'Editore deve essere una stringa',
            'genre.string' => 'Genere deve essere una stringa',
            'pages.integer' => 'Numero pagine deve essere un numero',
        ];
    }
}
