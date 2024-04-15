<?php

namespace App\Http\Controllers\Web\Carwash;

use App\Http\Controllers\Controller;
use App\Http\Requests\contentStoreRequest;
use App\Http\Requests\Web\carwashUpdateRequest;
use App\Models\Activation;
use App\Models\Media;
use App\Traits\UploadUtilsTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarwashController extends Controller
{
    use UploadUtilsTrait;

    public function dashboard()
    {
        $carwash = $this->request->current_carwash;

        return view('carwash.profile.show', compact('carwash'));
    }

    public function edit()
    {
        $carwash = $this->request->current_carwash;
        return view('carwash.profile.edit', compact('carwash'));
    }

    public function update(carwashUpdateRequest $request)
    {
        try {
            $carwash = $this->request->current_carwash;

            $title = $request->input('title');
            $address = $request->input('address');
            $mobile = $request->input('mobile');
            $code = $request->input('code');

            if ($mobile != $carwash->mobile) {
                $activation = Activation::where('mobile', $mobile)->first();
                if (!$activation) {
                    return redirect()->back()->withErrors(['error' => trans('trs.there_is_an_error')]);

                }

                if ($activation->attempt == 3) {
                    return redirect()->back()->withErrors(['error' => trans('trs.otp_too_many_attempt')]);
                }

                if ($activation->code != $code) {
                    $activation->update([
                        'attempt'    => $activation->attept + 1,
                        'attempt_at' => Carbon::now(),
                    ]);
                    return redirect()->back()->withErrors(['error' => trans('trs.otp_not_correct')]);
                }

                $activation->update([
                    'completed_at' => Carbon::now(),
                ]);
            }

            $carwash->update([
                'title'   => $title,
                'mobile'  => $mobile,
                'address' => $address,
            ]);

            if ($this->request->input('deleted_logo')) {
                $this->mediaRemove($carwash->logo['model'], 'assetsStorage');
            }

            if ($this->request->hasFile('logo')) {
                $logo = $this->request->file('logo');

                $this->imageUpload($logo, 'carwashLogo', 'assetsStorage', $carwash);
            }

            return redirect(route('carwash_dashboard'))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function notifications()
    {
        try {
            $carwash = $this->request->current_carwash;

            $carwash->notifications()->update([
                "seen" => 1,
            ]);
            $notifications = $carwash->notifications()->orderBy("created_at", "desc")->limit(30)->get();


            return view('carwash.notifications.index', compact('carwash', 'notifications'));
        } catch (\Exception) {
            return redirect()->back();
        }
    }

}
