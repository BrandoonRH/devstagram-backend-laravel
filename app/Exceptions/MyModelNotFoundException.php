<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MyModelNotFoundException extends ModelNotFoundException
{
    public function render($request)
    {
        return response()->json([
            'error' => 'Recurso no encontrado'
        ], 404);
    }
}
