<?php

namespace App\Http\Controllers;

use App\Services\PixbayService\Client;
use Illuminate\Http\Request;

class PixbayController extends Controller
{
    public function getImages(Request $request, Client $pixbayClient)
    {
        return $pixbayClient->getPhotos();
    }
}
