<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\UploadTempImageRequest;
use App\Traits\UploadUtilsTrait;

class MediaController extends Controller
{
    use UploadUtilsTrait;

    public function tmp(UploadTempImageRequest $request)
    {
        $file = $request->file('image');
        $media = $this->imageUpload($file, 'tmp', 'assetsStorage');
        return ['name' => $media["title"]];

    }
}
