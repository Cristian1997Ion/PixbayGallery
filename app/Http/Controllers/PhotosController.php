<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UserPhotosRequest;
use App\Jobs\StorePhotoJob;
use Exception;
use Illuminate\Http\JsonResponse;

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

        StorePhotoJob::dispatch(
            $request->getUser(),
            $request->json('photoId'),
            $request->json('photoUrl')
        );

        return response()->json(['success' => 'true']);
    }

    public function getUserPhotos(UserPhotosRequest $request): JsonResponse
    {
        $photos = array_map(
            function($photo){
                return [
                    'id'   => $photo['id'],
                    'url' => $photo['path'],
                ];
            },
            $request->getUser()->photos()->get()->toArray()
        );

        return response()->json(['photos' => $photos]);
    }
}
