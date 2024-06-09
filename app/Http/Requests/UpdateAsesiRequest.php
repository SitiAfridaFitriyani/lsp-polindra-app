<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateAsesiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nim' => ['required','min:8','numeric'],
            'email' => ['required', 'email', 'min:3', 'max:50'],
            'name' => ['required','min:3','string'],
            'phone'=>['nullable','regex:/(08)[0-9]{9}/'],
            'username' => ['required','string'],
            'photo' => [
                'nullable',
                File::types(['jpg', 'jpeg','png'])
                    ->min('1kb')
                    ->max('2mb'),
                ],
            'jenis_kelamin' => ['nullable','in:Laki-laki,Perempuan'],
            'address' => ['nullable','string'],
            'status' => ['nullable','in:active,nonactive']
        ];
    }

    public function messages()
    {
        return array(
            'required' => 'Data tidak boleh kosong',
            'max' => 'Maksimal berjumlah :max karakter',
            'min' => 'Minimal berjumlah :min karakter',
            'string' => 'Format harus berupa string',
            'unique' => 'Data tidak boleh sama',
            'email' => 'Masukkan format email yang benar',
            'numeric' => 'Format harus berupa angka',
            'in' => 'Data harus salah satu dari :values',
            'date' => 'Data harus berupa tanggal',
            'integer' => 'Data harus berupa angka',
            'mimes' => 'Format file harus :values',
            'photo.max' => 'Ukuran file maksimal 2 MB',
            'regex' => 'Format tidak sesuai'
        );
    }
}
