<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name'          => 'required',
            'description'   => 'required|min:10',
            'body'          => 'required',
            'price'         => 'required',     
            'photos.*'          => 'image'
        ];
    }
    
    public function messages()
    {
        return [
            'required' => 'Este campo :attribute é obrigatório',
            'min' => 'Campo deve ter no mínimo :min carateres',
            'image' => 'Arquivo não é uma imagem válida'
        ];
    }
}
