<?php

namespace App\Http\Controllers\Api\Other;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UploadTempImageRequest;
use App\Traits\ResponseUtilsTrait;
use App\Traits\UploadUtilsTrait;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    use UploadUtilsTrait, ResponseUtilsTrait;

    public function storeImage(UploadTempImageRequest $request)
    {
        try {
            $file = $request->file('image');
            $image_data = $this->imageUpload($file, 'tmp', 'assetsStorage');
            return $this->sendResponse($image_data,
                trans("messages.uploadImage.success"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.uploadImage.failed'));
        }
    }
}
