<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UserPhotosRequest;
use App\Models\Photo;
use Exception;
use Illuminate\Http\JsonResponse;
use Intervention\Image\Facades\Image;

class PhotosController extends Controller
{
    /**
     * @param StorePhotoRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(StorePhotoRequest $request): JsonResponse
    {
        $photo = $request
            ->getUser()
            ->photos()
            ->where('id', $request->json('photoId'))
            ->first();

        if (!empty($photo)) {
            throw new Exception("You already have this photo saved!");
        }

        $photo = Photo::query()
            ->where('id', $request->json('photoId'))
            ->first();

        if (!empty($photo)) {
            // no need to generate another thumbnail, just update the reference
            $request->getUser()->photos()->save($photo);
        } else {
            $ext         = pathinfo($request->json('photoUrl'), PATHINFO_EXTENSION);
            $photoName   = "photo_{$request->json('photoId')}.{$ext}";
            $tempPhoto   = file_get_contents($request->json('photoUrl'));
            $photo       = Image::make($tempPhoto);

            $photo
                ->resize($photo->width() / 2, $photo->height() / 2)
                ->save(storage_path('app/public/') . $photoName);

            $request->getUser()->photos()->create([
                'id'   => $request->json('photoId'),
                'path' => asset('/storage/' . $photoName)
            ]);
        }

        return response()->json(['success' => 'true']);
    }

    public function getUserPhotos(UserPhotosRequest $request): JsonResponse
    {
        $photos = array_map(
            function($photo){
                return [
                    'id'   => $photo['id'],
                    'path' => $photo['path'],
                ];
            },
            $request->getUser()->photos()->get()->toArray()
        );

        return response()->json($photos);
    }
}
