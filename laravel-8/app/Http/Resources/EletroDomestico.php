<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EletroDomestico extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'success' => true,
            'id' => $this->id,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'tensao' => $this->tensao,
            'preco' => $this->preco,
            'cor' => $this->cor,
            'marca_id' => $this->marca_id,
        ];
    }
}
