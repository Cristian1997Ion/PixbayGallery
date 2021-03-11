<?php

namespace App\Http\Controllers;

use App\Services\PixbayService\Client;
use App\Services\PixbayService\Response\GenericPhotosResponse;
use Illuminate\Http\Request;

class PixbayController extends Controller
{
    public function getImages(Request $request, Client $pixbayClient): GenericPhotosResponse
    {
        return $pixbayClient->getPhotos();
    }
}
