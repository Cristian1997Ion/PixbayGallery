<?php

namespace App\Http\Requests;

use App\Models\User;

/**
 * Class StorePhotoRequest
 * @package App\Http\Requests
 */
class StorePhotoRequest extends PrivateUserRequest
{
    protected const ACCEPTED_EXTENSIONS = ['jpg', 'png', 'jpeg'];

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
        return parent::authorize();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'userId'         => ['required'],
            'token'          => ['required'],
            'photoId'        => ['required'],
        ];
    }
}
