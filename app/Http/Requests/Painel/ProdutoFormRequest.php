<?php

namespace App\Http\Requests\Painel;

use App\Http\Requests\Request;

class ProdutoFormRequest extends Request
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
            'name'      => 'required|min:3|max:100',
            'descricao' => 'min:3|max:800',
            'preco'     => 'required|numeric'
        ];
    }
    
    public function messages() 
    {
        return [
            'name.required'  => 'O campo Nome é obrigatório.',
            'preco.numeric'  => 'Necessita apenas números.',
            'preco.required' => 'O campo Preço é obrigatório.'
        ];
    }
}
