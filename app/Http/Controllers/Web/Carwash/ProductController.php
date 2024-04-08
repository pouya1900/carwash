<?php

namespace App\Http\Controllers\Servant;

use App\Http\Controllers\Controller;
use App\Http\Requests\productStoreRequest;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\UploadUtilsTrait;

class ProductController extends Controller
{
    use UploadUtilsTrait;

    public function index()
    {
        $servant = $this->request->current_servant;

        return view('servant.products.index', compact('servant'));
    }

    public function create()
    {
        $servant = $this->request->current_servant;

        return view('servant.products.create', compact('servant'));
    }

    public function store(productStoreRequest $request)
    {
        try {
            $servant = $this->request->current_servant;

            $added_media = $request->input('added_media');
            $deleted_media = $request->input('deleted_media');


            $product = $servant->products()->create([
                "title"       => $request->input('title'),
                "description" => $request->input('description') ?? null,
                "price"       => $request->input('price'),
                "link"        => $request->input('link') ?? null,
            ]);

            if ($added_media) {
                foreach ($added_media as $media_name) {
                    $file = Storage::disk('privateStorage')->readStream('tmp/' . $media_name);
                    Storage::disk('assetsStorage')->writeStream('productImage/' . $media_name, $file);
                    Storage::disk('privateStorage')->delete('tmp/' . $media_name);

                    $media = Media::where('title', $media_name)->first();

                    $product->media()->save($media);
                    $media->update(['model_type' => 'productImage']);
                }
            }

            if ($deleted_media) {
                foreach ($deleted_media as $deleted_name) {
                    Storage::disk('assetsStorage')->delete('productImage/' . $deleted_name);

                    $media = Media::where('title', $deleted_name)->first();

                    $media->delete();
                }
            }

            if ($request->input('deleted_image_logo')) {
                $logo = $product->logo["model"];
                if ($logo) {
                    $this->mediaRemove($logo, 'assetsStorage');
                }
            }
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $this->imageUpload($logo, 'productLogo', 'assetsStorage', $product);
            }

            if ($request->hasFile('catalog')) {
                $old_catalog = $product->catalog["model"];
                $this->mediaRemove($old_catalog, 'assetsStorage');
                $catalog = $request->file('catalog');
                $this->documentUpload($catalog, 'productCatalog', 'assetsStorage', $product);
            }

            if ($request->input('deleted_video')) {
                $video = $product->video["model"];
                if ($video) {
                    $this->mediaRemove($video, 'assetsStorage');
                }
            }

            if ($request->hasFile('video')) {
                $video = $request->file('video');
                $this->videoUpload($video, $product, 'productVideo', 'assetsStorage');
            }

            return redirect(route('servant_products'))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function edit(Product $product)
    {
        $servant = $this->request->current_servant;

        if ($product->servant->id != $servant->id) {
            abort(403);
        }

        return view('servant.products.edit', compact('servant', 'product'));

    }

    public function update(productStoreRequest $request, Product $product)
    {
        try {
            $servant = $this->request->current_servant;

            if ($product->servant->id != $servant->id) {
                abort(403);
            }

            $added_media = $request->input('added_media');
            $deleted_media = $request->input('removed_media');


            $product->update([
                "title"       => $request->input('title'),
                "description" => $request->input('description') ?? null,
                "price"       => $request->input('price'),
                "link"        => $request->input('link') ?? null,
            ]);

            if ($added_media) {
                foreach ($added_media as $media_name) {
                    $file = Storage::disk('privateStorage')->readStream('tmp/' . $media_name);
                    Storage::disk('assetsStorage')->writeStream('productImage/' . $media_name, $file);
                    Storage::disk('privateStorage')->delete('tmp/' . $media_name);

                    $media = Media::where('title', $media_name)->first();

                    $product->media()->save($media);
                    $media->update(['model_type' => 'productImage']);
                }
            }
            if ($deleted_media) {
                foreach ($deleted_media as $deleted_name) {
                    Storage::disk('assetsStorage')->delete('productImage/' . $deleted_name);

                    $media = Media::where('title', $deleted_name)->first();

                    $media->delete();
                }
            }

            if ($request->input('deleted_image_logo')) {
                $logo = $product->logo["model"];
                if ($logo) {
                    $this->mediaRemove($logo, 'assetsStorage');
                }
            }
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $this->imageUpload($logo, 'productLogo', 'assetsStorage', $product);
            }

            if ($request->hasFile('catalog')) {
                $old_catalog = $product->catalog["model"];
                $this->mediaRemove($old_catalog, 'assetsStorage');
                $catalog = $request->file('catalog');
                $this->documentUpload($catalog, 'productCatalog', 'assetsStorage', $product);
            }

            if ($request->input('deleted_video')) {
                $video = $product->video["model"];
                if ($video) {
                    $this->mediaRemove($video, 'assetsStorage');
                }
            }

            if ($request->hasFile('video')) {
                $video = $request->file('video');
                $this->videoUpload($video, $product, 'productVideo', 'assetsStorage');
            }

            return redirect(route('servant_products'))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }


    public function delete(Product $product)
    {
        try {
            $servant = $this->request->current_servant;

            if ($product->servant->id != $servant->id) {
                abort(403);
            }

            $product->delete();

            return redirect(route('servant_products'))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }


}
