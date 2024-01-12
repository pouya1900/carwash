<?php

namespace App\Traits;


use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

trait UploadUtilsTrait
{
    public function imageUpload($file, $model_type, $disk)
    {
        $fileExtension = $file->getClientOriginalExtension();
        $baseName = preg_replace(['/\s+/'], ['-'], pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . time();
        $fileName = $baseName . '.' . $fileExtension;

        Storage::disk($disk)->putFileAs($model_type, $file, $fileName);
        [$width, $height] = getimagesize($file);

        $media = Media::create([
            "title"  => $fileName,
            "ext"    => $fileExtension,
            "size"   => $file->getSize() / 1024,
            "width"  => $width,
            "height" => $height,
        ]);
        $path = Storage::disk("assetsStorage")->path($model_type);
        $url = Storage::disk("assetsStorage")->url('') . $model_type;

        $file_path = $path . "/" . $fileName;

        $image_data = ['id' => $media->id];

        foreach (config("image.size") as $key => $value) {
            $image_name = $value["postfix"] . $fileName;
            $image_data[$key] = $url . "/" . $image_name;
            if ($value['height']) {
                ImageManager::gd()->read($file_path)
                    ->resize($value['width'], $value['height'])
                    ->save($path . "/" . $image_name);
            } else {
                ImageManager::gd()->read($file_path)
                    ->resize($value['width'], null)
                    ->save($path . "/" . $image_name);
            }
        }


        return $image_data;
    }

    public function mediaRemove($media, $disk)
    {
        if ($media) {
            Storage::disk($disk)->delete($media->model_type . '/' . $media->title);
            $media->delete();
        }
    }

}
