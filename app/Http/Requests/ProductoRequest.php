<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
            'nombre_producto'=>'required|min:1|max:45',
            'marca_producto'=>'required|min:1|max:45',
            'descripcion_producto'=>'required|min:1|max:150',
            'precio_producto'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'nombre_producto.*'=>'El nombre de producto ingresado no es valido',
            'marca_producto.*'=>'La descripcion de producto ingresada no es valido',
            'descripcion_producto.*'=>'La marca de producto ingresada no es valido',
            'precio_producto.required'=>'El precio de producto ingresado no es valido',
        ];
    }
}
