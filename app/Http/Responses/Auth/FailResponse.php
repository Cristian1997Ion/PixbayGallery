<?php


namespace App\Http\Responses\Auth;


use Illuminate\Contracts\Support\Responsable;

/**
 * Class FailResponse
 * @package App\Http\Responses\Auth
 */
class FailResponse implements Responsable
{
    /**
     * @return \string[][][]
     */
    public function toArray(): array
    {
        return ['errors' => ['email' => ['Authentication failed: wrong email or password']]];
    }

    public function toResponse($request)
    {
        return response()->json($this->toArray());
    }
}
