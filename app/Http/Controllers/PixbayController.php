<?php

namespace App\Http\Controllers;

use App\Services\PixbayService\Client;
use App\Services\PixbayService\Response\GenericPhotosResponse;
use Illuminate\Http\Request;

/**
 * Class PixbayController
 * @package App\Http\Controllers
 */
class PixbayController extends Controller
{
    /**
     * @param Request $request
     * @param Client $pixbayClient
     * @return GenericPhotosResponse
     * @throws \Exception
     */
    public function getImages(Request $request, Client $pixbayClient): GenericPhotosResponse
    {
        return $pixbayClient->getPhotos($request->get('q', ''));
    }
}
