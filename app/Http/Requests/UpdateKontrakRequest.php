<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKontrakRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pagu_id' => 'required',
            'pengadaan_id' => 'required',
            'penyedia' => 'required',
            'nomor' => 'required',
            'tanggal' => 'required',
            'jumlah' => 'required',
            'jangka_waktu' => 'required',
            'bukti' => 'required',
            'hps' => 'required',
            'dokumen' => [
                Rule::requiredIf(function () {
                    return $this->route('kontrak') == null;
                }),
                'nullable',
                'file',
                'mimes:pdf',
                'max:10240'
            ]
        ];
    }

    public function attributes()
    {
        return [
            'jumlah' => 'Nilai kontrak'
        ];
    }
}
