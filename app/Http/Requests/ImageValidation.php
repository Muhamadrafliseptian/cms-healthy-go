<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            [
                'img' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            ],
            [
                'img.required' => 'Gambar wajib diunggah.',
                'img.image' => 'File harus berupa gambar.',
                'img.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
                'img.max' => 'Ukuran gambar maksimal 2MB.',
            ]
        ];
    }
}
