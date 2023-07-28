<?php

namespace App\Http\Modules\Users\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class UpdateUserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [

            'name'             => 'required|string:max:255',
            'last_name'        => 'required|string:max:255',
            'document_type_id' => 'required|exists:document_types,id',
            'document'         => 'required|numeric:max:20',
            'cell_phone'       => 'nullable|numeric:max:15',
            'phone'            => 'nullable|numeric:max:15',
            'address'          => 'nullable|string:max:255',
            'email'            => 'required|email|unique:users,email,' . $this->id . ',id',
            'gender'           => 'required|string|in:Femenino,Masculino',
            'password'         => 'nullable|string|min:8',
            'role'             => 'required|exists:roles,name',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'name.required'             => 'El nombre es requerido',
            'last_name.required'        => 'El apellido es requerido',
            'document_type_id.required' => 'El campo tipo de documento es obligatorio',
            'document_type_id.exists'   => 'El tipo de documento no existe',
            'document.required'         => 'El campo documento es obligatorio',
            'document.numeric'          => 'El campo documento debe ser numérico',
            'document.max'              => 'El campo documento debe tener máximo 20 caracteres',
            'cell_phone.numeric'        => 'El campo celular debe ser numérico',
            'cell_phone.max'            => 'El campo celular debe tener máximo 15 caracteres',
            'phone.numeric'             => 'El campo teléfono debe ser numérico',
            'phone.max'                 => 'El campo teléfono debe tener máximo 15 caracteres',
            'address.string'            => 'El campo dirección debe ser texto',
            'email.required'            => 'El campo email es obligatorio',
            'email.email'               => 'El campo email debe ser un email',
            'email.unique'              => 'El email ya está en uso',
            'gender.required'           => 'El campo género es obligatorio',
            'gender.string'             => 'El campo género debe ser un string',
            'gender.in'                 => 'El campo género debe ser uno de los siguientes valores: Femenino,Masculino',
            'password.required'         => 'El campo contraseña es obligatorio',
            'password.string'           => 'El campo contraseña debe ser un string',
            'password.min'              => 'El campo contraseña debe tener mínimo 8 caracteres',
            'role.required'             => 'El campo rol es obligatorio',
            'role.exists'               => 'El rol no existe',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_BAD_REQUEST));
    }
}
