<?php

namespace App\Http\Controllers\Api\Carwash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Traits\ResponseUtilsTrait;
use App\Traits\UploadUtilsTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ResponseUtilsTrait, UploadUtilsTrait;

    public function index()
    {
        try {
            $carwash = $this->request->carwash;

            $per_page = $this->getPerPage();

            $products = $carwash->products()->paginate($per_page);

            return $this->sendResponse([
                "products"   => ProductResource::collection($products),
                'pagination' => [
                    "totalItems"      => $products->total(),
                    "perPage"         => $products->perPage(),
                    "nextPageUrl"     => $products->nextPageUrl(),
                    "previousPageUrl" => $products->previousPageUrl(),
                    "lastPageUrl"     => $products->url($products->lastPage()),
                ],
            ]);
        } catch (\Exception) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $carwash = $this->request->carwash;

            $product = $carwash->products()->create([
                "title"       => $request->input("title"),
                "category_id" => $request->input("category_id"),
                "description" => $request->input("description") ?? "",
                "price"       => $request->input("price"),
            ]);

            $images_id = [$request->input("logo_id")];
            $this->updateImages($product, 'productLogo', "assetsStorage", $images_id);

            $images_id = $request->input("images_id");
            $this->updateImages($product, 'productImages', "assetsStorage", $images_id);

            return $this->sendResponse([
                "product" => new ProductResource($product),
            ], trans("messages.crud.createdModelSuccess"));
        } catch (\Exception|\Throwable $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }


    public function update(StoreProductRequest $request, Product $product)
    {
        try {
            $carwash = $this->request->carwash;

            if ($carwash->id != $product->carwash->id) {
                return $this->sendError(trans('messages.crud.illegalAccess'));
            }

            $product->update([
                "title"       => $request->input("title"),
                "category_id" => $request->input("category_id"),
                "description" => $request->input("description") ?? "",
                "price"       => $request->input("price"),
            ]);

            $images_id = [$request->input("logo_id")];
            $this->updateImages($product, 'productLogo', "assetsStorage", $images_id);

            $images_id = $request->input("images_id");
            $this->updateImages($product, 'productImages', "assetsStorage", $images_id);


            return $this->sendResponse([
                "product" => new ProductResource($product),
            ], trans("messages.crud.updatedModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }


    public function delete(Product $product)
    {
        try {
            $carwash = $this->request->carwash;

            if ($carwash->id != $product->carwash->id) {
                return $this->sendError(trans('messages.crud.illegalAccess'));
            }

            $product->media()->delete();
            $product->delete();

            return $this->sendResponse([], trans("messages.crud.deletedModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }
}
