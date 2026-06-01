<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if (! $this->has('nama_lengkap') && $this->has('name')) {
            $this->merge(['nama_lengkap' => $this->input('name')]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class, 'email')->ignore($this->user()->id_user, 'id_user'),
            ],
            'nomor_telepon' => ['nullable', 'string', 'max:30'],
            'jenis_kelamin' => ['nullable', 'in:laki-laki,perempuan'],
            'foto_profil' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'hapus_foto_profil' => ['nullable', 'boolean'],
        ];
    }
}
