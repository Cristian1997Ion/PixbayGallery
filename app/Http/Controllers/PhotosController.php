<?php

namespace App\Http\Controllers;

use App\Http\Requests\RemovePhotoRequest;
use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UserPhotosRequest;
use App\Jobs\RemovePhotoJob;
use App\Jobs\StorePhotoJob;
use App\Models\Photo;
use App\Services\PixbayService\Client;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Class PhotosController
 * @package App\Http\Controllers
 */
class PhotosController extends Controller
{
    /**
     * @param UserPhotosRequest $request
     * @return JsonResponse
     */
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

    /**
     * @param StorePhotoRequest $request
     * @param Client $pixbayService
     * @return JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(StorePhotoRequest $request, Client $pixbayService): JsonResponse
    {
        $pixbayPhoto = $pixbayService->getPhoto($request->json('photoId'));
        $userPhoto   = $request
            ->getUser()
            ->photos()
            ->where('id', $request->json('photoId'))
            ->first()
        ;

        if (!empty($userPhoto)) {
            throw new Exception("You already have this photo saved!");
        }

        $photo = new Photo(['id' => $pixbayPhoto->getId(), 'path' => $pixbayPhoto->getUrl()]);
        StorePhotoJob::dispatch(
            $request->getUser(),
            $photo
        );

        return response()->json(['success' => 'true']);
    }

    /**
     * @param RemovePhotoRequest $request
     * @return JsonResponse
     */
    public function removeUserPhoto(RemovePhotoRequest $request): JsonResponse
    {
        RemovePhotoJob::dispatch(
            $request->getUser(),
            $request->getPhoto(),
        );

        return response()->json(['success' => true]);
    }
}
