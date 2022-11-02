<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class EletroDomesticoRequest extends FormRequest
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

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }

    public function validationData()
    {
        $dados = $this->request->all();
        $dados['preco'] = str_replace(['.'], '', $dados['preco']);
        return $dados;
    }

    protected function prepareForValidation() 
    {
        // $this->merge(['field' => 'field value' ]);
    } 

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // $request = request();
        // $id = request()->route('eletro-domestico');
        // $id = app('request')->eletro-domestico;
        // $id = request()->segment(3);
        // $id = \Request::instance()->eletro-domestico;
        
        $id = $this->route('eletro-domestico');

        // validacao para update e insert
        $validation = [
            'nome' => 'required|min:3|max:200|regex:/^[\p{L}\p{N} \-\_\.\:\?]+$/u',
            'marca_id' => 'required|integer|gt:0|exists:marcas,id',
            'tensao' => 'required|max:255',
            'descricao' => 'required|max:255',
            'cor' => 'required|max:255',
            'preco' => 'required|regex:/^\d+(\,\d{1,2})?$/',
        ];

        // validacao apenas para update
        if ($this->isMethod('put') || $this->isMethod('patch')) {
        }
        // validacao apenas para insert
        else {
        }

        return $validation;
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // 'title.required' => 'A title is required',
            'required' => 'Campo :attribute é obrigatório',
            'exists' => ':attribute é Inválido',
            'gt' => ':attribute é Inválido',
            'integer' => ':attribute é Inválido',
            'max' => ':attribute é Inválido',
            'min' => ':attribute é Inválido',
            'regex' => ':attribute é Inválido',
        ];
    }

    public function attributes()
    {
        return [
            'nome' => 'Nome',
            'marca_id' => 'Marca',
            'tensao' => 'Tensão',
            'descricao' => 'Descrição',
            'cor' => 'Cor',
            'preco' => 'Preço',
        ];
    }
}
