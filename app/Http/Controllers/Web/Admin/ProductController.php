<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreProductRequest;
use App\Models\Carwash;
use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use App\Traits\UploadUtilsTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use UploadUtilsTrait;

    public function index(Carwash $carwash = null)
    {
        $admin = $this->request->admin;

        $products = Product::when($carwash, function ($q) use ($carwash) {
            return $q->where('carwash_id', $carwash->id);
        })->orderBy("created_at", "desc")->get();

        return view('admin.products.index', compact('admin', 'carwash', 'products'));
    }

    public function create(Carwash $carwash)
    {
        $admin = $this->request->admin;

        $categories = Category::all();

        return view('admin.products.create', compact('admin', 'carwash', 'categories'));
    }

    public function store(StoreProductRequest $request, Carwash $carwash)
    {
        try {
            $admin = $this->request->admin;

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

            return redirect(route('admin.products', $carwash->id))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function edit(Product $product)
    {
        $admin = $this->request->admin;

        $carwash = $product->carwash;

        $categories = Category::all();


        return view('admin.products.edit', compact('admin', 'carwash', 'product', 'categories'));

    }

    public function update(StoreProductRequest $request, Product $product)
    {
        try {
            $admin = $this->request->admin;

            $carwash = $product->carwash;

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

            return redirect(route('admin.products', $carwash->id))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }


    public function delete(Product $product)
    {
        try {
            $admin = $this->request->admin;

            $carwash = $product->carwash;

            $this->mediaRemove($product->logo["model"], 'assetsStorage');

            foreach ($product->images as $image) {
                $this->mediaRemove($image["model"], 'assetsStorage');
            }

            $product->delete();

            return redirect(route('admin.products', $carwash->id))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }
}
