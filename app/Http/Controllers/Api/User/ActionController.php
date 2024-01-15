<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Carwash;
use App\Models\Product;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    public function like_product(Product $product)
    {
        try {
            $user = $this->request->user;
            if ($like = $product->likes()->where("user_id", $user->id)->first()) {
                $like->delete();
                $is_like = 0;
            } else {
                $product->likes()->create([
                    "user_id" => $user->id,
                ]);
                $is_like = 1;
            }

            return $this->sendResponse([
                "is_like" => $is_like,
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function like_carwash(Carwash $carwash)
    {
        try {
            $user = $this->request->user;
            if ($like = $carwash->likes()->where("user_id", $user->id)->first()) {
                $like->delete();
                $is_like = 0;
            } else {
                $carwash->likes()->create([
                    "user_id" => $user->id,
                ]);
                $is_like = 1;
            }

            return $this->sendResponse([
                "is_like" => $is_like,
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function bookmark_product(Product $product)
    {
        try {
            $user = $this->request->user;
            if ($bookmark = $product->bookmarks()->where("user_id", $user->id)->first()) {
                $bookmark->delete();
                $is_bookmark = 0;
            } else {
                $product->bookmarks()->create([
                    "user_id" => $user->id,
                ]);
                $is_bookmark = 1;
            }

            return $this->sendResponse([
                "is_bookmark" => $is_bookmark,
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function bookmark_carwash(Carwash $carwash)
    {
        try {
            $user = $this->request->user;
            if ($bookmark = $carwash->bookmarks()->where("user_id", $user->id)->first()) {
                $bookmark->delete();
                $is_bookmark = 0;
            } else {
                $carwash->bookmarks()->create([
                    "user_id" => $user->id,
                ]);
                $is_bookmark = 1;
            }

            return $this->sendResponse([
                "is_bookmark" => $is_bookmark,
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }


}
