<?php


namespace App\Http\Requests;


use App\Models\User;

class StorePhotoRequest extends PrivateUserRequest
{
    /**
     * @var User
     */
    protected $user;

    protected const ACCEPTED_EXTENSIONS = ['jpg', 'png', 'jpeg'];

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
            'photoUrl'       => [
                'required',
                function($attribute, $value, $fail) {
                    $ext = pathinfo($value, PATHINFO_EXTENSION);
                    if (in_array($ext, self::ACCEPTED_EXTENSIONS)) {
                        return;
                    }

                    $error = sprintf(
                        "extension not supported (supported: %s)",
                        implode(', ',self::ACCEPTED_EXTENSIONS)
                    );

                    $fail($error);
                }
            ]
        ];
    }
}
