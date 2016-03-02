<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ImagemRepository;

class ImagemController extends Controller
{

    public function crop($width, $height, $name, ImagemRepository $image) {
        return $image->get($width, $height, $name, false);
    }

    public function thumb($width, $height, $name, ImagemRepository $image) {
        return $image->get($width, $height, $name, true);
    }

}
