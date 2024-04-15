<?php

namespace App\Http\Controllers\Web\Carwash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreProductRequest;
use App\Models\Category;
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
        $carwash = $this->request->current_carwash;

        return view('carwash.products.index', compact('carwash'));
    }

    public function create()
    {
        $carwash = $this->request->current_carwash;

        $categories = Category::all();

        return view('carwash.products.create', compact('carwash', 'categories'));
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $carwash = $this->request->current_carwash;

            $added_media = $request->input('added_media');
            $deleted_media = $request->input('deleted_media');

            $product = $carwash->products()->create([
                "title"       => $request->input("title"),
                "category_id" => $request->input("category"),
                "description" => $request->input("description") ?? "",
                "price"       => $request->input("price"),
                "discount"    => $request->input("discount"),
            ]);

            if ($added_media || $deleted_media) {
                $new_images_id = $added_media ? Media::whereIn('title', $added_media)->pluck("id")->toArray() : [];
                $deleted_images_id = $deleted_media ? Media::whereIn('title', $deleted_media)->pluck("id")->toArray() : [];

                $this->updateImages($product, "productImages", "assetsStorage", $new_images_id, $deleted_images_id);
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

            return redirect(route('carwash_products'))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function edit(Product $product)
    {
        $carwash = $this->request->current_carwash;

        if ($product->carwash->id != $carwash->id) {
            return abort(403);
        }

        $categories = Category::all();


        return view('carwash.products.edit', compact('carwash', 'product', 'categories'));

    }

    public function update(StoreProductRequest $request, Product $product)
    {
        try {
            $carwash = $this->request->current_carwash;

            if ($product->carwash->id != $carwash->id) {
                abort(403);
            }

            $added_media = $request->input('added_media');
            $deleted_media = $request->input('removed_media');


            $product->update([
                "title"       => $request->input("title"),
                "category_id" => $request->input("category"),
                "description" => $request->input("description") ?? "",
                "price"       => $request->input("price"),
                "discount"    => $request->input("discount"),
            ]);

            if ($added_media || $deleted_media) {
                $new_images_id = $added_media ? Media::whereIn('title', $added_media)->pluck("id")->toArray() : [];
                $deleted_images_id = $deleted_media ? Media::whereIn('title', $deleted_media)->pluck("id")->toArray() : [];

                $this->updateImages($product, "productImages", "assetsStorage", $new_images_id, $deleted_images_id);

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

            return redirect(route('carwash_products'))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }


    public function delete(Product $product)
    {
        try {
            $carwash = $this->request->current_carwash;

            if ($product->carwash->id != $carwash->id) {
                return abort(403);
            }

            $this->mediaRemove($product->logo["model"], 'assetsStorage');

            foreach ($product->images as $image) {
                $this->mediaRemove($image["model"], 'assetsStorage');
            }

            $product->delete();

            return redirect(route('carwash_products'))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }


}
