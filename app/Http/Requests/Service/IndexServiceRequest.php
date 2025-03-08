<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class IndexServiceRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return[
            'search'=> 'nullable|string',
            'sort_by'=> 'nullable|in:name,price,duration',
            'order'=> 'nullable|in:asc,desc',
        ];
    }

    public function messages(){
        return [
            'search.string' => 'Pesquisa inválido, apenas palavras.',
            'sort_by.in' => 'O campo de ordenação é inválida.',
            'order.in'=> 'A direção da ordenação é inválida.'
        ];
    }
}
