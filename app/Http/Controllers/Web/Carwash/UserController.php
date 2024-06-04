<?php

namespace App\Http\Controllers\Web\Carwash;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        $carwash = $this->request->current_carwash;

        $radius = $this->request->input('radius');

        if (!$radius) {
            $radius = 100;
        }

        $rad = M_PI / 180;
        $r = 6371;//earth radius in kilometers
        $lat = $carwash->lat;
        $long = $carwash->long;
        $users = User::whereRaw("(acos( sin( lat * $rad ) * sin( $lat * $rad ) + cos( lat * $rad ) * cos( $lat * $rad ) * cos( users.long * $rad - $long * $rad ) ) * $r ) < $radius  ")->get();

        return view('carwash.users.index', compact('users', 'carwash', 'radius'));
    }

}
