<?php

namespace App\Http\Controllers\Api\Reservation;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\BaseItemResource;
use App\Http\Resources\BaseServiceResource;
use App\Http\Resources\CarwashFullResource;
use App\Http\Resources\CarwashResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ScoreResource;
use App\Http\Resources\ServiceResource;
use App\Models\Base_service;
use App\Models\Carwash;
use App\Models\Category;
use App\Models\Item;
use App\Models\Lock_product;
use App\Models\Product;
use App\Models\Score;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class CarwashController extends Controller
{

    public function index()
    {
        try {
            $per_page = $this->getPerPage();

            $user = $this->request->user;
            $lat = $this->request->input("lat");
            $long = $this->request->input("long");
            $radius = $this->request->input("radius") ?: 10;
            $search = $this->request->input("search");
            $carwash_id = $this->request->input("carwash_id");
            $services_id = json_decode($this->request->input("services_id"), true);
            $types_id = json_decode($this->request->input("types_id"), true);

            $j_date = $this->request->input("date");
            $time = $this->request->input("time");
            $date = Jalalian::fromFormat('Y-m-d', $j_date)->addHours($time)->toCarbon();

            $is_promoted = $this->request->input("is_promoted");
            $is_certified = $this->request->input("is_certified");
            $is_new = $this->request->input("is_new");
            $is_like = $this->request->input("is_like");
            $is_bookmark = $this->request->input("is_bookmark");
            $is_discount = $this->request->input("is_discount");
            $order_by_score = $this->request->input("order_by_score");


            $carwashes = Carwash::when($order_by_score, function ($q) {
                return $q->withAvg("scores", "rate")->orderBy("scores_avg_rate", "desc");
            })->when($lat, function ($q) use ($lat, $long, $radius) {
                $rad = M_PI / 180;
                $r = 6371; //earth radius in kilometers
                return $q->whereRaw("(acos( sin( lat * $rad ) * sin( $lat * $rad ) + cos( lat * $rad ) * cos( $lat * $rad ) * cos( carwashes.long * $rad - $long * $rad ) ) * $r ) < $radius  ")
                    ->orderByRaw("acos( sin( lat * $rad ) * sin( $lat * $rad ) + cos( lat * $rad ) * cos( $lat * $rad ) * cos( carwashes.long * $rad - $long * $rad ) ) * $r  ASC");
            })->when($search, function ($q) use ($search) {
                return $q->where("title", "like", "%$search%");
            })->when($carwash_id, function ($q) use ($carwash_id) {
                return $q->where("id", $carwash_id);
            })->when($is_promoted, function ($q) {
                return $q->where("promoted", 1);
            })->when($is_certified, function ($q) {
                return $q->where("certified", 1);
            })->when($is_new, function ($q) {
                return $q->where("created_at", ">=", Carbon::now()->subDays(7));
            })->when($is_like && $user, function ($q) use ($user) {
                return $q->wherehas("likes", function ($q) use ($user) {
                    return $q->where("user_id", $user->id);
                });
            })->when($is_bookmark && $user, function ($q) use ($user) {
                return $q->wherehas("bookmarks", function ($q) use ($user) {
                    return $q->where("user_id", $user->id);
                });
            })->when(!empty($services_id), function ($q) use ($services_id, $types_id) {
                return $q->wherehas("services", function ($q) use ($services_id, $types_id) {
                    return $q->whereIn("base_id", $services_id)
                        ->when(!empty($types_id), function ($q) use ($types_id) {
                            return $q->wherehas("types", function ($q) use ($types_id) {
                                return $q->whereIn("type_id", $types_id);
                            });
                        });
                });
            })->when(!empty($types_id), function ($q) use ($types_id) {
                return $q->wherehas("services", function ($q) use ($types_id) {
                    return $q->wherehas("types", function ($q) use ($types_id) {
                        return $q->whereIn("type_id", $types_id);
                    });
                })->with("services", function ($q) use ($types_id) {
                    return $q->wherehas("types", function ($q) use ($types_id) {
                        return $q->whereIn("type_id", $types_id);
                    });
                });
            })->when(!empty($is_discount), function ($q) use ($types_id, $date) {
                return $q->wherehas("services", function ($q) use ($types_id) {
                    return $q->when(!empty($types_id), function ($q) use ($types_id) {
                        return $q->wherehas("types", function ($q) use ($types_id) {
                            return $q->whereIn("type_id", $types_id);
                        });
                    })->where("discount", ">", 0);
                })->orwherehas("discounts", function ($q) use ($date) {
                    return $q->where("start", "<=", $date)->where("end", ">", $date)->where("value", ">", 0);
                });
            })->where("status", "accepted")->paginate($per_page);

            return $this->sendResponse([
                "carwashes"  => CarwashResource::collection($carwashes),
                'pagination' => [
                    "totalItems"      => $carwashes->total(),
                    "perPage"         => $carwashes->perPage(),
                    "nextPageUrl"     => $carwashes->nextPageUrl(),
                    "previousPageUrl" => $carwashes->previousPageUrl(),
                    "lastPageUrl"     => $carwashes->url($carwashes->lastPage()),
                ],
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }

    }

    public function times_list()
    {
        try {
            $per_page = $this->getPerPage();

            $user = $this->request->user;
            $lat = $this->request->input("lat");
            $long = $this->request->input("long");
            $radius = $this->request->input("radius") ?: 10;
            $search = $this->request->input("search");
            $carwash_id = $this->request->input("carwash_id");
            $services_id = json_decode($this->request->input("services_id"), true);
            $types_id = json_decode($this->request->input("types_id"), true);

            $is_promoted = $this->request->input("is_promoted");
            $is_certified = $this->request->input("is_certified");
            $is_new = $this->request->input("is_new");
            $is_like = $this->request->input("is_like");
            $is_bookmark = $this->request->input("is_bookmark");
            $is_discount = $this->request->input("is_discount");
            $order_by_score = $this->request->input("order_by_score");


            $carwashes = Carwash::when($order_by_score, function ($q) {
                return $q->withAvg("scores", "rate")->orderBy("scores_avg_rate", "desc");
            })->when($lat, function ($q) use ($lat, $long, $radius) {
                $rad = M_PI / 180;
                $r = 6371; //earth radius in kilometers
                return $q->whereRaw("(acos( sin( lat * $rad ) * sin( $lat * $rad ) + cos( lat * $rad ) * cos( $lat * $rad ) * cos( carwashes.long * $rad - $long * $rad ) ) * $r ) < $radius  ")
                    ->orderByRaw("acos( sin( lat * $rad ) * sin( $lat * $rad ) + cos( lat * $rad ) * cos( $lat * $rad ) * cos( carwashes.long * $rad - $long * $rad ) ) * $r  ASC");
            })->when($search, function ($q) use ($search) {
                return $q->where("title", "like", "%$search%");
            })->when($carwash_id, function ($q) use ($carwash_id) {
                return $q->where("id", $carwash_id);
            })->when($is_promoted, function ($q) {
                return $q->where("promoted", 1);
            })->when($is_certified, function ($q) {
                return $q->where("certified", 1);
            })->when($is_new, function ($q) {
                return $q->where("created_at", ">=", Carbon::now()->subDays(7));
            })->when($is_like && $user, function ($q) use ($user) {
                return $q->wherehas("likes", function ($q) use ($user) {
                    return $q->where("user_id", $user->id);
                });
            })->when($is_bookmark && $user, function ($q) use ($user) {
                return $q->wherehas("bookmarks", function ($q) use ($user) {
                    return $q->where("user_id", $user->id);
                });
            })->when(!empty($services_id), function ($q) use ($services_id, $types_id) {
                return $q->wherehas("services", function ($q) use ($services_id, $types_id) {
                    return $q->whereIn("base_id", $services_id)
                        ->when(!empty($types_id), function ($q) use ($types_id) {
                            return $q->wherehas("types", function ($q) use ($types_id) {
                                return $q->whereIn("type_id", $types_id);
                            });
                        });
                });
            })->when(!empty($types_id), function ($q) use ($types_id) {
                return $q->wherehas("services", function ($q) use ($types_id) {
                    return $q->wherehas("types", function ($q) use ($types_id) {
                        return $q->whereIn("type_id", $types_id);
                    });
                })->with("services", function ($q) use ($types_id) {
                    return $q->wherehas("types", function ($q) use ($types_id) {
                        return $q->whereIn("type_id", $types_id);
                    });
                });
            })->when(!empty($is_discount), function ($q) use ($types_id) {
                return $q->wherehas("services", function ($q) use ($types_id) {
                    return $q->when(!empty($types_id), function ($q) use ($types_id) {
                        return $q->wherehas("types", function ($q) use ($types_id) {
                            return $q->whereIn("type_id", $types_id);
                        });
                    })->where("discount", ">", 0);
                })->orwherehas("discounts", function ($q) {
                    return $q->where("value", ">", 0);
                });
            })->where("status", "accepted")->get();


            $times = [];

            for ($i = 0; $i < 8; $i++) {
                $day = Carbon::now()->addDays($i)->startOfDay();
                $times[$i]["date"] = jdate(strtotime($day))->format("Y-m-d");
                $times[$i]["times"] = [];
                $hour = Carbon::now()->hour + 1;
                $start = !$i ? $hour : 0;

                for ($j = $start; $j < 24; $j++) {
                    $total = 0;
                    $number = 0;
                    $numberCarwash = 0;
                    foreach ($carwashes as $carwash) {
                        $response = Helper::isFree($carwash, $day, $j);
                        if (isset($response["number"])) {
                            $total += $response["total"];
                            $number += $response["number"];
                        }
                        if ($response["is_free"]) {
                            $numberCarwash++;
                        }
                    }
                    $times[$i]["times"][] = [
                        "start"         => $j,
                        "end"           => $j + 1,
                        "total"         => $total,
                        "number"        => $number,
                        "totalCarwash"  => $carwashes->count(),
                        "numberCarwash" => $numberCarwash,
                    ];
                }
            }

            return $this->sendResponse([
                "times" => $times,
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }

    }

    public function show(Carwash $carwash)
    {
        try {

            return $this->sendResponse([
                "carwash" => new CarwashFullResource($carwash),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }

    }


    public function products()
    {
        try {
            $per_page = $this->getPerPage();

            $user = $this->request->user;

            $search = $this->request->input("search");
            $carwash_id = $this->request->input("carwash_id");
            $categories_id = json_decode($this->request->input("categories_id"), true);

            $lat = $this->request->input("lat");
            $long = $this->request->input("long");
            $radius = $this->request->input("radius") ?: 10;

            $is_rated = $this->request->input("is_rated");
            $is_discount = $this->request->input("is_discount");
            $is_best_seller = $this->request->input("is_best_seller");
            $is_new = $this->request->input("is_new");
            $is_like = $this->request->input("is_like");
            $is_bookmark = $this->request->input("is_bookmark");

            $products = Product::selectRaw("products.* , carwashes.lat , carwashes.long")->when($search, function ($q) use ($search) {
                return $q->where("products.title", "like", "%$search%")->orwhere("products.description", "like", "%$search%");
            })->when($carwash_id, function ($q) use ($carwash_id) {
                return $q->where("carwash_id", $carwash_id);
            })->when(!empty($categories_id), function ($q) use ($categories_id) {
                return $q->whereIn("category_id", $categories_id);
            })->when($lat, function ($q) use ($lat, $long, $radius) {
                $rad = M_PI / 180;
                $r = 6371; //earth radius in kilometers
                return $q->wherehas("carwash", function ($q) use ($lat, $long, $radius) {
                    $rad = M_PI / 180;
                    $r = 6371; //earth radius in kilometers
                    return $q->whereRaw("(acos( sin( lat * $rad ) * sin( $lat * $rad ) + cos( lat * $rad ) * cos( $lat * $rad ) * cos( carwashes.long * $rad - $long * $rad ) ) * $r ) < $radius  ");
                })->join("carwashes", "carwashes.id", "products.carwash_id")->orderByRaw("acos( sin( carwashes.lat * $rad ) * sin( $lat * $rad ) + cos( carwashes.lat * $rad ) * cos( $lat * $rad ) * cos( carwashes.long * $rad - $long * $rad ) ) * $r ASC");
            })->when($is_new, function ($q) {
                return $q->where("products.created_at", ">=", Carbon::now()->subDays(7));
            })->when($is_like && $user, function ($q) use ($user) {
                return $q->wherehas("likes", function ($q) use ($user) {
                    return $q->where("user_id", $user->id);
                });
            })->when($is_bookmark && $user, function ($q) use ($user) {
                return $q->wherehas("bookmarks", function ($q) use ($user) {
                    return $q->where("user_id", $user->id);
                });
            })->when($is_discount, function ($q) {
                return $q->where("products.discount", ">", 0);
            })->when($is_best_seller, function ($q) {
                $lock_products = Lock_product::selectRaw("count(*) as count , product_id")->wherehas("product")->orderBy("count", "desc")->groupBy("product_id")->limit(5)->get()->pluck("product_id")->toArray();
                return $q->wherein("products.id", $lock_products);
            })->when($is_rated, function ($q) {
                $top_score_products = Score::selectRaw("avg(rate) as avg , scorable_id")->where("scorable_type", Product::class)->orderBy("avg", "desc")->groupBy("scorable_id")->limit(5)->get()->pluck("scorable_id")->toArray();
                return $q->wherein("products.id", $top_score_products);
            })->paginate($per_page);
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
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function services(Carwash $carwash)
    {
        try {
            $per_page = $this->getPerPage();

            $services = $carwash->services()->paginate($per_page);

            return $this->sendResponse([
                "services"   => ServiceResource::collection($services),
                'pagination' => [
                    "totalItems"      => $services->total(),
                    "perPage"         => $services->perPage(),
                    "nextPageUrl"     => $services->nextPageUrl(),
                    "previousPageUrl" => $services->previousPageUrl(),
                    "lastPageUrl"     => $services->url($services->lastPage()),
                ],
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function product_show(Product $product)
    {
        try {

            return $this->sendResponse([
                "product" => new ProductResource($product),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }

    }

    public function service_show(Service $service)
    {
        try {
            return $this->sendResponse([
                "service" => new ServiceResource($service),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }

    }

    public function times(Carwash $carwash)
    {
        try {
            $free_times = Helper::getFreeTimes($carwash);

            return $this->sendResponse([
                "free" => $free_times,
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function categories()
    {
        try {
            $per_page = $this->getPerPage();

            $categories = Category::paginate($per_page);

            return $this->sendResponse([
                "categories" => CategoryResource::collection($categories),
                'pagination' => [
                    "totalItems"      => $categories->total(),
                    "perPage"         => $categories->perPage(),
                    "nextPageUrl"     => $categories->nextPageUrl(),
                    "previousPageUrl" => $categories->previousPageUrl(),
                    "lastPageUrl"     => $categories->url($categories->lastPage()),
                ],
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function carwash_scores(Carwash $carwash)
    {
        try {

            $scores = $carwash->scores;

            return $this->sendResponse([
                "scores" => ScoreResource::collection($scores),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function product_scores(Product $product)
    {
        try {

            $scores = $product->scores;

            return $this->sendResponse([
                "scores" => ScoreResource::collection($scores),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function base_services()
    {
        try {

            $is_main = $this->request->input("is_main");

            $base_services = Base_service::when($is_main, function ($q) {
                return $q->where("is_main", 1);
            })->get();


            return $this->sendResponse([
                "services" => BaseServiceResource::collection($base_services),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }


    }

    public function base_items()
    {
        try {
            $base_items = Item::all();

            return $this->sendResponse([
                "items" => BaseItemResource::collection($base_items),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }

    }

}
