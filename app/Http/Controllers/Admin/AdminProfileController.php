<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminProfileController extends Controller
{
    public function profile_edit () {
        return view("admin.profile");
    }
    public function profile_update (Request $request) {
        $request->validate([
            "email"=>"required|email|exists:users,email",
            "name"=>"required",
            "current_password"=>"nullable|min:8|max:13",
            "password"=>"nullable|min:8|max:13",
            "confirm_password"=>"same:password",
        ]);

        $admin=User::where("email",$request->email)->first();

        if(!$admin)
            return redirect()->back()->with("error","User not found.");

        $admin->email=$request->email;
        $admin->name=$request->name;
            
        if($request->hasFile("avatar")){
            $request->validate([
                "avatar"=>"required|file|mimes:jpg,png,jpeg|max:1048576",
            ]);

            $avatar=uniqid().".".$request->file("avatar")->getClientOriginalExtension();

            if(!is_dir(public_path("uploads/admin")))
                mkdir(public_path("uploads/admin"),0577,true);

            if(strpos($admin->avatar,"avatar") === false && is_file(public_path("uploads/admin/").$admin->avatar))
               unlink(public_path("uploads/admin/").$admin->avatar);

            list($width,$height)=getimagesize($request->file("avatar")->getPathname());
            $thumbnail=imagecreatetruecolor($width,$height);

            switch($request->file("avatar")->getClientOriginalExtension()){
                case "jpg": case "jpeg": $source_img=imagecreatefromjpeg($request->file("avatar")->getPathname());break;
                case "png": $source_img=imagecreatefrompng($request->file("avatar")->getPathname());break;
                default: return redirect()->back()->with("error","Invalid image format.");
            }

            imagecopyresampled($thumbnail,$source_img,0,0,0,0,$width,$height,$width,$height);
            imagejpeg($thumbnail,public_path("uploads/admin/").$avatar,90);

            imagedestroy($thumbnail);
            imagedestroy($source_img);

            $admin->avatar=$avatar;
        }

        if(!empty($request->current_password)){

            if(!password_verify($request->current_password,$admin->password))
                return redirect()->back()->with("error","Current password is incorrect.");

            $admin->password=password_hash($request->password,PASSWORD_DEFAULT);
        }

        if(!$admin->update())
            return redirect()->back()->with("error","Profile update failed. Please try again.");

        return redirect()->back()->with("success","Profile updated successfully.");
    }
}
