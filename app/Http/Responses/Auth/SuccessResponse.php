<?php


namespace App\Http\Responses\Auth;


use App\Models\User;
use Illuminate\Contracts\Support\Responsable;

class SuccessResponse implements Responsable
{
    /**
     * @var User
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function toArray(): array
    {
        return [
            'success' => true,
            'user'    => [
                'id'    => $this->user->id,
                'name'  => $this->user->name,
                'token' => $this->user->token,
            ]
        ];
    }

    public function toResponse($request)
    {
        return response()->json($this->toArray());
    }
}
