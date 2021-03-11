<?php


namespace App\Http\Requests;


use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

abstract class PrivateUserRequest extends FormRequest
{
    /**
     * @var User
     */
    protected $user;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $user = User::query()
            ->where('id', $this->request->get('userId'))
            ->where('token', $this->request->get('token'))
            ->first();

        if (empty($user)) {
            // token and user_id don't match
            return false;
        }

        $this->user = $user;

        return true;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
