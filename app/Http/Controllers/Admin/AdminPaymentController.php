<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use App\Services\PaymentSettingsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    public function payment_paypal_edit ():View 
    {
        $paymentSettings=PaymentSetting::pluck("value","key");
        return view("admin.payment.paypal",compact("paymentSettings"));
    }
    public function payment_stripe_edit ():View 
    {
        $paymentSettings=PaymentSetting::pluck("value","key");
        return view("admin.payment.stripe",compact("paymentSettings"));
    }
    public function payment_razorpay_edit ():View 
    {
        $paymentSettings=PaymentSetting::pluck("value","key");
        
        return view("admin.payment.razorpay",compact("paymentSettings"));
    }

    public function payment_paypal_update(Request $request)
    {
        try{
            $validatedData = $request->validate([
                "paypal_status"=>"nullable|string|in:on",
                "paypal_account_mode"=>"required|string",
                "paypal_country"=>"required|string",
                "paypal_currency"=>"required|string",
                "paypal_rate"=>"required|numeric",
                "paypal_api_key"=>"required|string",
                "paypal_secret_key"=>"required|string",
                "paypal_app_id"=>"required|string",
            ]);
    
            if($request->hasFile("paypal_logo")){
                $request->validate([
                    "paypal_logo"=>"file|mimes:jpg,jpeg,png|max:1048576",
                ]);
    
                $path=public_path("uploads/payment/");
                $tmp=$request->file("paypal_logo")->getPathname();
                $extentsion=strtolower($request->file("paypal_logo")->getClientOriginalExtension());
                $image=uniqid().".".$extentsion;
    
                if(!is_dir($path))
                    mkdir($path,0577,true);
    
                $image_old= PaymentSetting::where("key", "paypal_logo")->first();
                if($image_old && is_file($path.$image_old->value))
                    unlink($path.$image_old->value);
    
                list($width,$height)=getimagesize($tmp);
                $thumbnail=imagecreatetruecolor($width,$height);
    
                switch($extentsion){
                    case "jpg": case "jpeg": $source_img=imagecreatefromjpeg($tmp);break;
                    case "png": $source_img=imagecreatefrompng($tmp);break;
                    default: throw new \Exception("Invalid image format.");
                }
    
                imagecopyresampled($thumbnail,$source_img,0,0,0,0,$width,$height,$width,$height);
    
                switch($extentsion){
                    case "jpg": case "jpeg": imagejpeg($thumbnail,$path.$image,90);break;
                    case "png": imagepng($thumbnail,$path.$image,9);break;
                }
    
                imagedestroy($thumbnail);
                imagedestroy($source_img);

                PaymentSetting::updateOrCreate(
                    ['key' => 'paypal_logo'],
                    ['value' => $image]
                );
            }
    
            $paypal_status = ($request->input('paypal_status') === 'on') ? 1 : 0;
            PaymentSetting::updateOrCreate(
                ['key' => 'paypal_status'],
                ['value' => $paypal_status]
            );


            foreach($validatedData as $key => $value)
                if($key !== 'paypal_status')
                    PaymentSetting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value]
                    );

            $paymentSettingService = app(PaymentSettingsService::class);
            $paymentSettingService->clearCachedSettings();
    
            return redirect()->route("admin.payment.paypal.edit")->with("success","Payment settings updated successfully.");
        }catch(\Exception $err){
            return redirect()->back()->with("error",$err->getMessage());
        }
    }
    public function payment_stripe_update(Request $request)
    {
        try{
            $validatedData = $request->validate([
                "stripe_status"=>"nullable|string|in:on",
                "stripe_country"=>"required|string",
                "stripe_currency"=>"required|string",
                "stripe_rate"=>"required|numeric",
                "stripe_api_key"=>"required|string",
                "stripe_secret_key"=>"required|string",
            ]);
    
            if($request->hasFile("stripe_logo")){
                $request->validate([
                    "stripe_logo"=>"file|mimes:jpg,jpeg,png|max:1048576",
                ]);
    
                $path=public_path("uploads/payment/");
                $tmp=$request->file("stripe_logo")->getPathname();
                $extentsion=strtolower($request->file("stripe_logo")->getClientOriginalExtension());
                $image=uniqid().".".$extentsion;
    
                if(!is_dir($path))
                    mkdir($path,0577,true);
    
                $image_old= PaymentSetting::where("key", "stripe_logo")->first();
                if($image_old && is_file($path.$image_old->value))
                    unlink($path.$image_old->value);
    
                list($width,$height)=getimagesize($tmp);
                $thumbnail=imagecreatetruecolor($width,$height);
    
                switch($extentsion){
                    case "jpg": case "jpeg": $source_img=imagecreatefromjpeg($tmp);break;
                    case "png": $source_img=imagecreatefrompng($tmp);break;
                    default: throw new \Exception("Invalid image format.");
                }
    
                imagecopyresampled($thumbnail,$source_img,0,0,0,0,$width,$height,$width,$height);
    
                switch($extentsion){
                    case "jpg": case "jpeg": imagejpeg($thumbnail,$path.$image,90);break;
                    case "png": imagepng($thumbnail,$path.$image,9);break;
                }
    
                imagedestroy($thumbnail);
                imagedestroy($source_img);

                PaymentSetting::updateOrCreate(
                    ['key' => 'stripe_logo'],
                    ['value' => $image]
                );
            }
    
            $stripe_status = ($request->input('stripe_status') === 'on') ? 1 : 0;
            PaymentSetting::updateOrCreate(
                ['key' => 'stripe_status'],
                ['value' => $stripe_status]
            );


            foreach($validatedData as $key => $value)
                if($key !== 'stripe_status')
                    PaymentSetting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value]
                    );

            $paymentSettingService = app(PaymentSettingsService::class);
            $paymentSettingService->clearCachedSettings();
    
            return redirect()->route("admin.payment.stripe.edit")->with("success","Payment settings updated successfully.");
        }catch(\Exception $err){
            return redirect()->back()->with("error",$err->getMessage());
        }
    }
    public function payment_razorpay_update(Request $request)
    {
        try{
            $validatedData = $request->validate([
                "razorpay_status"=>"nullable|string|in:on",
                "razorpay_country"=>"required|string",
                "razorpay_currency"=>"required|string",
                "razorpay_rate"=>"required|numeric",
                "razorpay_api_key"=>"required|string",
                "razorpay_secret_key"=>"required|string",
            ]);
    
            if($request->hasFile("razorpay_logo")){
                $request->validate([
                    "razorpay_logo"=>"file|mimes:jpg,jpeg,png|max:1048576",
                ]);
    
                $path=public_path("uploads/payment/");
                $tmp=$request->file("razorpay_logo")->getPathname();
                $extentsion=strtolower($request->file("razorpay_logo")->getClientOriginalExtension());
                $image=uniqid().".".$extentsion;
    
                if(!is_dir($path))
                    mkdir($path,0577,true);
    
                $image_old= PaymentSetting::where("key", "razorpay_logo")->first();
                if($image_old && is_file($path.$image_old->value))
                    unlink($path.$image_old->value);
    
                list($width,$height)=getimagesize($tmp);
                $thumbnail=imagecreatetruecolor($width,$height);
    
                switch($extentsion){
                    case "jpg": case "jpeg": $source_img=imagecreatefromjpeg($tmp);break;
                    case "png": $source_img=imagecreatefrompng($tmp);break;
                    default: throw new \Exception("Invalid image format.");
                }
    
                imagecopyresampled($thumbnail,$source_img,0,0,0,0,$width,$height,$width,$height);
    
                switch($extentsion){
                    case "jpg": case "jpeg": imagejpeg($thumbnail,$path.$image,90);break;
                    case "png": imagepng($thumbnail,$path.$image,9);break;
                }
    
                imagedestroy($thumbnail);
                imagedestroy($source_img);

                PaymentSetting::updateOrCreate(
                    ['key' => 'razorpay_logo'],
                    ['value' => $image]
                );
            }
    
            $razorpay_status = ($request->input('razorpay_status') === 'on') ? 1 : 0;
            PaymentSetting::updateOrCreate(
                ['key' => 'razorpay_status'],
                ['value' => $razorpay_status]
            );


            foreach($validatedData as $key => $value)
                if($key !== 'razorpay_status')
                    PaymentSetting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value]
                    );
    
            $paymentSettingService = app(PaymentSettingsService::class);
            $paymentSettingService->clearCachedSettings();
            
            return redirect()->route("admin.payment.razorpay.edit")->with("success","Payment settings updated successfully.");
        }catch(\Exception $err){
            return redirect()->back()->with("error",$err->getMessage());
        }
    }
}
