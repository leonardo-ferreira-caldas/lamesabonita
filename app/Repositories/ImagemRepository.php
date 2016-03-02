<?php
/**
 * Created by PhpStorm.
 * User: leonardo
 * Date: 22/09/15
 * Time: 21:20
 */

namespace App\Repositories;

use Image;

class ImagemRepository
{

    private $path = 'images/uploads/';
    private $thumbPath = 'images/thumbs/';

    private function getThumbName($width, $height, $name) {
        $split = explode(".", $name);
        $ext = array_pop($split);
        $split[] = sprintf('%sx%s', $width, $height);
        $split[] = $ext;
        return implode(".", $split);
    }

    public function get($width, $height, $name, $thumb)
    {
        if ($thumb) {
            return $this->getWithThumb($width, $height, $name);
        }

        return $this->getWithoutThumb($width, $height, $name);

    }

    public function getWithThumb($width, $height, $name) {
        $pathFit = $this->thumbPath . $this->getThumbName($width, $height, $name);

        if (!file_exists($pathFit)) {
            $path = $this->path . $name;
            $img = Image::make($path);
            $img->save($pathFit, 90);
        }

        $img = Image::make($pathFit)->fit($width, $height);
        return $img->response();
    }

    public function getWithoutThumb($width, $height, $name) {
        $path = $this->path . $name;
        $img = Image::make($path)->fit($width, $height);
        return $img->response();
    }

}