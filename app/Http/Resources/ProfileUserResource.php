<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //Control total sobre lo que vamos a returnar en las respuestas 
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'username' => $this->icono,
            'email' => $this->email
        ]; 
    }
}
