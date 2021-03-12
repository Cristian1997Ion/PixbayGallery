<?php

namespace App\Http\Requests;

use App\Models\Photo;

/**
 * Class RemovePhotoRequest
 * @package App\Http\Requests
 */
class RemovePhotoRequest extends PrivateUserRequest
{
    /**
     * @var Photo
     */
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
    public function rules(): array
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

    /**
     * @return Photo
     */
    public function getPhoto(): Photo
    {
        return $this->photo;
    }
}
