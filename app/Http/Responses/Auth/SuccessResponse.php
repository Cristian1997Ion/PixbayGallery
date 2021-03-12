<?php


namespace App\Http\Responses\Auth;


use App\Models\User;
use Illuminate\Contracts\Support\Responsable;

/**
 * Class SuccessResponse
 * @package App\Http\Responses\Auth
 */
class SuccessResponse implements Responsable
{
    /**
     * @var User
     */
    protected $user;

    /**
     * SuccessResponse constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return array
     */
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
