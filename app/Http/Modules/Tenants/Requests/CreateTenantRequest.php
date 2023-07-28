<?php

namespace App\Http\Modules\Tenants\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateTenantRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id'               => 'required|string|max:255|unique:tenants,id',
            'name'             => 'required|string|max:255',
            'logo'             => 'nullable|string|max:255',
            'document_type_id' => 'required|exists:document_types,id',
            'document_number'  => 'required|unique:tenants,document_number,NULL,id,document_type_id,' . $this->input('document_type_id'),
            'data'             => 'nullable|json',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        //español
        return [
            'id.required'               => 'El campo id es obligatorio.',
            'id.string'                 => 'El campo id debe ser de tipo string.',
            'id.max'                    => 'El campo id debe tener máximo 255 caracteres.',
            'id.unique'                 => 'El campo id ya existe.',
            'name.required'             => 'El campo nombre es obligatorio.',
            'name.string'               => 'El campo nombre debe ser de tipo string.',
            'name.max'                  => 'El campo nombre debe tener máximo 255 caracteres.',
            'logo.string'               => 'El campo logo debe ser de tipo string.',
            'logo.max'                  => 'El campo logo debe tener máximo 255 caracteres.',
            'document_type_id.required' => 'El campo tipo de documento es obligatorio.',
            'document_type_id.exists'   => 'El campo tipo de documento no existe.',
            'document_number.required'  => 'El campo número de documento es obligatorio.',
            'document_number.unique'    => 'El campo número de documento debe ser único.',
            'data.json'                 => 'El campo data debe ser de tipo json.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
