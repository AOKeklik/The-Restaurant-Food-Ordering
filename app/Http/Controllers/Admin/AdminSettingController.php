<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Unique;

class AdminSettingController extends Controller
{
    /* settings */
    public function settings ():View{
        return view("admin.settings");
    }
    public function settings_update (Request $request){
        $request->validate([
            "site_name"=>"required|string",
            "site_favicon"=>"nullable|file|mimes:jpg,png,jpeg|max:1048576",
            "site_top_logo"=>"nullable|file|mimes:jpg,png,jpeg|max:1048576",
            "site_footer_logo"=>"nullable|file|mimes:jpg,png,jpeg|max:1048576",
            "site_currency"=>"required|string",
            "site_currency_icon"=>"required|string",
            "site_currency_position"=>"required|string",
            "site_address"=>"required|string",
            "site_email"=>"required|email",
            "site_phone"=>"required|string",

            "seo_title"=>"nullable|string",
            "seo_description"=>"nullable|string",
            "seo_keywords"=>"nullable|string",

            "link_facebook"=>"nullable|url",
            "link_linkedin"=>"nullable|url",
            "link_behance"=>"nullable|url",
            "link_twitter"=>"nullable|url",
        ]);

        $setting=Setting::first();

        if(!$setting)
            return redirect()->back()->with("error","Settings not found.");

        if($request->hasFile("site_favicon"))
            $setting->site_favicon= $this->helper_img ($request,"site_favicon",$setting->site_favicon);

        if($request->hasFile("site_top_logo"))
            $setting->site_top_logo= $this->helper_img ($request,"site_top_logo",$setting->site_top_logo);

        if($request->hasFile("site_footer_logo"))
            $setting->site_footer_logo= $this->helper_img ($request,"site_footer_logo",$setting->site_footer_logo);
        

        $setting->site_name=$request->site_name;
        $setting->site_short_description=$request->site_short_description;
        $setting->site_currency=$request->site_currency;
        $setting->site_currency_icon=$request->site_currency_icon;
        $setting->site_currency_position=$request->site_currency_position;
        $setting->site_address=$request->site_address;
        $setting->site_email=$request->site_email;
        $setting->site_phone=$request->site_phone;

        $setting->seo_title=$request->seo_title;
        $setting->seo_description=$request->seo_description;
        $setting->seo_keywords=$request->seo_keywords;

        $setting->link_facebook=$request->link_facebook;
        $setting->link_linkedin=$request->link_linkedin;
        $setting->link_behance=$request->link_behance;
        $setting->link_twitter=$request->link_twitter;
        
        if(!$setting->save())
            return redirect()->back()->with("error","Failed to update settings.");

        return redirect()->back()->with("success","Settings updated successfully.");
    }


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

    /* menu */
    public function menu():View {
        return view("admin.setting_menu");
    }
    public function menu_update (Request $request){
        $request->validate([
            "menu_title"=>"required|string",
            "menu_sub_title"=>"required|string",
            "menu_description"=>"required|string",
            "menu_status"=>"nullable",
        ]);

        $setting=Setting::first();

        if(!$setting)
            return redirect()->back()->with("error","Settings not found.");
        

        $setting->menu_title=$request->menu_title;
        $setting->menu_sub_title=$request->menu_sub_title;
        $setting->menu_description=$request->menu_description;
        $setting->menu_status=$request->has("menu_status") ? 1 : 0;
        
        if(!$setting->save())
            return redirect()->back()->with("error","Failed to update settings.");

        return redirect()->back()->with("success","Settings updated successfully.");
    }

    public function helper_img ($request,$field,$old_img){
            $path=public_path("uploads/setting/");
            $tmp=$request->file($field)->getPathname();
            $extension=$request->file($field)->getClientOriginalExtension();
            $image=uniqid().".".$extension;

            if(!is_dir($path))
                mkdir($path,0577,true);

            if(is_file($path.$old_img))
                unlink($path.$old_img);

            list($width,$height)=getimagesize($tmp);
            $thumbnail=imagecreatetruecolor($width,$height);

            if ($extension == "png") {
                imagealphablending($thumbnail, false);
                $color = imagecolorallocatealpha($thumbnail, 0, 0, 0, 127);
                imagefill($thumbnail, 0, 0, $color);
                imagesavealpha($thumbnail, true);
            }

            switch($extension){
                case "jpg": case "jpeg": $source_image=imagecreatefromjpeg($tmp);break;
                case "png": $source_image=imagecreatefrompng($tmp);break;
                default: return redirect()->back()->with("Invalid image format.");
            }

            imagecopyresampled($thumbnail,$source_image,0,0,0,0,$width,$height,$width,$height);

            switch($extension){
                case "jpg": case "jpeg": imagejpeg($thumbnail,$path.$image,90);break;
                case "png": imagepng($thumbnail,$path.$image,9);break;
            }

            imagedestroy($thumbnail);
            imagedestroy($source_image);


            return $image;
    }
}
