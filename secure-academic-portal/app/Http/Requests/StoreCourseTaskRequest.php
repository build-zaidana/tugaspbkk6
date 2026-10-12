<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCourseTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:150'],
            'mata_kuliah' => ['required', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string', 'max:5000'],
            'tanggal_pengumpulan' => ['required', 'date_format:Y-m-d'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'judul.required' => 'Judul tugas wajib diisi.',
            'mata_kuliah.required' => 'Mata kuliah wajib diisi.',
            'tanggal_pengumpulan.required' => 'Tanggal pengumpulan wajib diisi.',
            'tanggal_pengumpulan.date_format' => 'Tanggal pengumpulan harus berupa tanggal yang valid.',
        ];
    }
}
