<?php


namespace App\Http\Responses\Auth;


use Illuminate\Contracts\Support\Responsable;

class FailResponse implements Responsable
{
    public function toArray(): array
    {
        return ['error' => 'Authentication failed: wrong email or password'];
    }

    public function toResponse($request)
    {
        return response()->json($this->toArray());
    }
}
