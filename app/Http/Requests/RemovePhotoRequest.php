<?php

namespace App\Http\Requests;

use App\Models\Photo;

class RemovePhotoRequest extends PrivateUserRequest
{
    protected $photo;

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
    public function rules()
    {
        return [
            'photoId' => ['required'],
            'token'   => ['required'],
            'userId'  => ['required'],
        ];
    }

    public function prepareForValidation()
    {
        $this->photo = Photo::query()
            ->where('id', $this->json('photoId'))
            ->first();

        parent::prepareForValidation();
    }

    public function getPhoto()
    {
        return $this->photo;
    }
}
