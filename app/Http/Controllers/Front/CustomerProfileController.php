<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerProfileController extends Controller
{
    public function dashboard () : View {
        return view("front.customer_dashboard");
    }

    public function avatar_update (Request $request) {
        $request->validate([
            "avatar"=>"required|file|mimes:jpg,png,jpeg|max:1048576",
        ]);

        $customer=User::find(Auth::guard("user")->user()->id);

        if(!$customer)
            return redirect()->back()->with("error","User not found.");

        if(!is_dir(public_path("uploads/customer/")))
            mkdir(public_path("uploads/customer/"),0577,true);

        if(strpos($customer->avatar,"avatar") === false && is_file(public_path("uploads/customer/").$customer->avatar))
            unlink(public_path("uploads/customer/").$customer->avatar);

        $avatar=uniqid().".".$request->file("avatar")->getClientOriginalExtension();

        list($width,$height)=getimagesize($request->file("avatar")->getPathname());
        $thumbnail=imagecreatetruecolor($width,$height);

        switch($request->file("avatar")->getClientOriginalExtension()){
            case "jpg": case "jpeg": $source_image=imagecreatefromjpeg($request->file("avatar")->getPathname());break;
            case "png": $source_image=imagecreatefrompng($request->file("avatar")->getPathname());break;
            default: redirect()->back()->with("error","Invalid image format.");
        }

        imagecopyresampled($thumbnail,$source_image,0,0,0,0,$width,$height,$width,$height);
        imagejpeg($thumbnail,public_path("uploads/customer/").$avatar,90);

        imagedestroy($thumbnail);
        imagedestroy($source_image);

        $customer->avatar=$avatar;

        if(!$customer->update())
            return redirect()->back()->with("error","Failed to update avatar.");

        return redirect()->back()->with("success","Avatar updated successfully.");
    }
    public function profile_update (Request $request) {
        $request->validate([
            "name"=>"required|string",
            "email"=>"required|email|unique:users,email,".Auth::guard("user")->user()->id,
        ]);

        $customer=User::find(Auth::guard("user")->user()->id);

        if(!$customer)
            return redirect()->back()->with("error","User not found.");

        $customer->name=$request->name;
        $customer->email=$request->email;

        if(!$customer->update())
            return redirect()->back()->with("error","Failed to update profile.");

        return redirect()->back()->with("success","Profile updated successfully.");
    }
    public function password_update (Request $request) {
        $request->validate([
            "current_password"=>"required|string",
            "password"=>"required|string|min:7|max:13",
            "confirm_password"=>"required|string|same:password"
        ]);

        $customer=User::find(Auth::guard("user")->user()->id);

        if(!$customer)
            return redirect()->back()->with("error","User not found.");

        if(!password_verify($request->current_password,$customer->password))
            return redirect()->back()->with("error","Current password is incorrect.");

        $customer->password=password_hash($request->password,PASSWORD_DEFAULT);

        if(!$customer->update())
            return redirect()->back()->with("error","Failed to update the password.");

        return redirect()->back()->with("success","Password updated successfully.");
    }
}
