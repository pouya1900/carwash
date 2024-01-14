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

    public function updateImages($model, $model_type, $disk, $images_id)
    {
        if (!$images_id) {
            $images_id = [];
        }

        $delete_images = $model->media()->where("model_type", $model_type)->whereNotIn("id", $images_id)->get();

        $new_images = Media::whereIn("id", $images_id)->whereNull("mediable_id")->get();

        $image_sizes = config("image.size");
        $image_sizes[] = [
            "postfix" => "",
        ];
        foreach ($new_images as $new_image) {

            foreach ($image_sizes as $key => $value) {
                $file = Storage::disk('assetsStorage')->readStream('tmp/' . $value["postfix"] . $new_image->title);
                Storage::disk($disk)->writeStream($model_type . '/' . $value["postfix"] . $new_image->title, $file);
                Storage::disk('assetsStorage')->delete('tmp/' . $value["postfix"] . $new_image->title);
            }

            $model->media()->save($new_image);
            $new_image->update(['model_type' => $model_type]);

        }

        foreach ($delete_images as $delete_image) {
            foreach ($image_sizes as $key => $value) {
                Storage::disk($disk)->delete($model_type . '/' . $value["postfix"] . $delete_image->title);
            }
            $delete_image->delete();
        }
    }

    public function mediaRemove($media, $disk)
    {
        if ($media) {
            Storage::disk($disk)->delete($media->model_type . '/' . $media->title);
            $media->delete();
        }
    }

}
