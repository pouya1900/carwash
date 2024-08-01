<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Activation;
use App\Services\notification\FireBase;

class TestController extends Controller
{

    public function index()
    {
        $fire_base = new FireBase();

        $fire_base->sendNotification("e45UW6I3QdKtQEM_JzMMgq:APA91bGg5OjtH9ZlnEyKrnJVIRh3wuS6qujhDVoH9a7srWfjHVYSOHI3K8WM8XJXzq8XYOpupukydcT0l9pGbBe61LVmW-UPyjuNFRzREGXyf9OIntrzrsHHSu6A1b3YGt7uRRCncgWr", "bdfbfd", "bdfbdfb");
    }

}
