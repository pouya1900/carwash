<?php

namespace App\Http\Controllers\Api\Other;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Http\Resources\ColorResource;
use App\Http\Resources\ModelResource;
use App\Http\Resources\TypeResource;
use App\Models\Brand;
use App\Models\Car_model;
use App\Models\Color;
use App\Models\Type;
use App\Traits\ResponseUtilsTrait;
use Illuminate\Http\Request;

class CarPropertyController extends Controller
{
    use ResponseUtilsTrait;

    public function carProperty()
    {
        try {

            $types = Type::all();
            $brands = Brand::all();
            $models = Car_model::all();
            $colors = Color::all();

            return $this->sendResponse([
                "types"  => TypeResource::collection($types),
                "brands" => BrandResource::collection($brands),
                "models" => ModelResource::collection($models),
                "colors" => ColorResource::collection($colors),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }

    }

    public function types()
    {
        try {

            $types = Type::all();

            return $this->sendResponse([
                "types" => TypeResource::collection($types),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function brands()
    {
        try {

            $brands = Brand::all();

            return $this->sendResponse([
                "brands" => BrandResource::collection($brands),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function models()
    {
        try {
            $brand = $this->request->input('brand');

            $models = Car_model::when($brand, function ($q) use ($brand) {
                return $q->where("brand_id", $brand);
            })->get();

            return $this->sendResponse([
                "models" => ModelResource::collection($models),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function colors()
    {
        try {

            $colors = Color::all();

            return $this->sendResponse([
                "colors" => ColorResource::collection($colors),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }
}
