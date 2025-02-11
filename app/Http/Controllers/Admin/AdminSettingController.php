<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function slider_update (Request $request){
        $request->validate([
            "slider_status"=>"nullable",
        ]);

        $setting=Setting::first();

        if(!$setting)
            return redirect()->back()->with("error","Settings not found.");
        
        
        if($request->hasFile("slider_photo")){
            $request->validate([
                "slider_photo"=>"required|file|mimes:jpg,jpeg,png|max:1048576",
            ]);

            $path=public_path("uploads/setting/");
            $extension = strtolower($request->file("slider_photo")->getClientOriginalExtension());
            $tmp = $request->file("slider_photo")->getPathname();
            $photo=uniqid().".".$extension;

            if(!is_dir($path))
                mkdir($path,0577,true);
        
            if(!empty($setting->slider_photo) && is_file($path.$photo))
                unlink($path.$photo);

            list($width,$height)=getimagesize($tmp);
            $thumbnail=imagecreatetruecolor($width,$height);

            switch($extension){
                case "jpg": case "jpeg": $source_image=imagecreatefromjpeg($tmp);break;
                case "png": $source_image=imagecreatefrompng($tmp);break;
                default: return redirect()->back()->with("error","Invalid image format."); 
            }

            imagecopyresampled($thumbnail,$source_image,0,0,0,0,$width,$height,$width,$height);

            switch($extension){
                case "jpg": case "jpeg": imagejpeg($thumbnail,$path.$photo,90);break;
                case "png": imagepng($thumbnail,$path.$photo,9);break;
            }

            imagedestroy($thumbnail);
            imagedestroy($source_image);

            $setting->slider_photo=$photo;
        }

        $setting->slider_status=$request->has("slider_status") ? 1 : 0;
        
        if(!$setting->save())
            return redirect()->back()->with("error","Failed to update settings.");

        return redirect()->back()->with("success","Settings updated successfully.");
    }
    public function why_choose_update (Request $request){
        $request->validate([
            "why_choose_title"=>"required|string",
            "why_choose_sub_title"=>"required|string",
            "why_choose_description"=>"required|string",
            "why_choose_status"=>"nullable",
        ]);

        $setting=Setting::first();

        if(!$setting)
            return redirect()->back()->with("error","Settings not found.");
        

        $setting->why_choose_title=$request->why_choose_title;
        $setting->why_choose_sub_title=$request->why_choose_sub_title;
        $setting->why_choose_description=$request->why_choose_description;
        $setting->why_choose_status=$request->has("why_choose_status") ? 1 : 0;
        
        if(!$setting->save())
            return redirect()->back()->with("error","Failed to update settings.");

        return redirect()->back()->with("success","Settings updated successfully.");
    }
}
