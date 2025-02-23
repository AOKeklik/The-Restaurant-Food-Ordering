<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminSliderController extends Controller
{
    public function slides() :View{
        $slides=Slider::orderBy("id","desc")->get();
        return view("admin.setting_slides",compact("slides"));
    }
    public function slides_add() :View{
        return view("admin.setting_slide_add");
    }
    public function slides_edit($slide_id) :View{
        $slide=Slider::find($slide_id);

        if(!$slide)
            return redirect()->route("admin.setting.slides")->with("error","The slide not found.");

        return view("admin.setting_slide_edit",compact("slide"));
    }



    public function slides_store(Request $request) {
        $request->validate([
            "image"=>"required|file|mimes:jpg,jpeg,png|max:1048576",
            "offer"=>"required|string",
            "title"=>"required|string",
            "sub_title"=>"required|string",
            "button_link"=>"nullable|url",
            "short_description"=>"required|string",
        ]);

        $slide=new Slider();

        if($request->hasFile("image")){
            $image=uniqid().".".strtolower($request->file("image")->getClientOriginalExtension());

            if(!is_dir(public_path("uploads/slider/")))
                mkdir(public_path("uploads/slider/"),0577,true);

            list($width,$height)= getimagesize($request->file("image")->getPathname());
            $thumbnail=imagecreatetruecolor($width,$height);

            switch(strtolower($request->file("image")->getClientOriginalExtension())){
                case "jpg": case "jpeg": $source_img=imagecreatefromjpeg($request->file("image")->getPathname());break;
                case "png": $source_img=imagecreatefrompng($request->file("image")->getPathname());break;
                default: return redirect()->back()->with("error","Unsupported image format.");
            }

            imagecopyresampled($thumbnail,$source_img,0,0,0,0,$width,$height,$width,$height);
            
            switch(strtolower($request->file("image")->getClientOriginalExtension())){
                case "jpg": case "jpeg": imagejpeg($thumbnail,public_path("uploads/slider/").$image,90);break;
                case "png": imagepng($thumbnail,public_path("uploads/slider/").$image,9);break;
            }

            imagedestroy($thumbnail);
            imagedestroy($source_img);

            $slide->image=$image;
        }

        $slide->offer=$request->offer;
        $slide->title=$request->title;
        $slide->sub_title=$request->sub_title;
        $slide->button_link=$request->button_link;
        $slide->short_description=$request->short_description;

        if(!$slide->save())
            return redirect()->back()->with("error","Failed to save slide."); 

        return redirect()->route("admin.setting.slides")->with("success","Slide added successfully.");
    }
    public function slides_update(Request $request) {
        $request->validate([
            "slide_id"=>"required|string|exists:sliders,id",
            "offer"=>"required|string",
            "title"=>"required|string",
            "sub_title"=>"required|string",
            "button_link"=>"nullable|url",
            "short_description"=>"required|string",
        ]);

        $slide=Slider::find($request->slide_id);;

        if($request->hasFile("image")){
            $request->validate([
                "image"=>"required|file|mimes:jpg,jpeg,png|max:1048576",
            ]);
            
            $image=uniqid().".".strtolower($request->file("image")->getClientOriginalExtension());

            if(!is_dir(public_path("uploads/slider/")))
                mkdir(public_path("uploads/slider/"),0577,true);

            if(is_file(public_path("uploads/slider/").$slide->image))
                unlink(public_path("uploads/slider/").$slide->image);

            list($width,$height)= getimagesize($request->file("image")->getPathname());
            $thumbnail=imagecreatetruecolor($width,$height);

            switch(strtolower($request->file("image")->getClientOriginalExtension())){
                case "jpg": case "jpeg": $source_img=imagecreatefromjpeg($request->file("image")->getPathname());break;
                case "png": $source_img=imagecreatefrompng($request->file("image")->getPathname());break;
                default: return redirect()->back()->with("error","Unsupported image format.");
            }

            imagecopyresampled($thumbnail,$source_img,0,0,0,0,$width,$height,$width,$height);
            
            switch(strtolower($request->file("image")->getClientOriginalExtension())){
                case "jpg": case "jpeg": imagejpeg($thumbnail,public_path("uploads/slider/").$image,90);break;
                case "png": imagepng($thumbnail,public_path("uploads/slider/").$image,9);break;
            }

            imagedestroy($thumbnail);
            imagedestroy($source_img);

            $slide->image=$image;
        }

        $slide->offer=$request->offer;
        $slide->title=$request->title;
        $slide->sub_title=$request->sub_title;
        $slide->button_link=$request->button_link;
        $slide->short_description=$request->short_description;

        if(!$slide->save())
            return redirect()->back()->with("error","Failed to update slide."); 

        return redirect()->route("admin.setting.slides")->with("success","Slide updated successfully.");
    }
    public function slides_status_update(Request $request){
        $validator = \Validator::make($request->all(), [
            "slide_id" => "required|numeric|exists:sliders,id",
            "status" => "required|numeric|in:1,0",
        ]);

        if(!$validator->passes())
            return response()->json(["error" => ["message" => $validator->errors()->first()]]);

        $slide=Slider::find($request->slide_id);

        if(!$slide)
            return response()->json(["error"=>["message"=>"Slide not found."]]);

        $slide->status=$request->status;

        if(!$slide->save())
            return response()->json(["error"=>["message"=>"Failed to update slide status."]]);

        return response()->json(["success"=>["message"=>"Slide status updated successfully."]]);
    }
    public function slides_delete(Request $request){
        $validator = \Validator::make($request->all(), [
            "slide_id" => "required|numeric|exists:sliders,id"
        ]);

        if(!$validator->passes())
            return response()->json(["error" => ["message" => $validator->errors()->first()]]);

        $slide=Slider::find($request->slide_id);

        if(!$slide)
            return response()->json(["error"=>["message"=>"Slide not found."]]);

        if(is_file(public_path("uploads/slider/").$slide->image))
            unlink(public_path("uploads/slider/").$slide->image);

        if(!$slide->delete())
            return response()->json(["error"=>["message"=>"Failed to delete the slide."]]);

        return response()->json(["success"=>["message"=>"The slide deleted successfully."]]);
    }
}

