<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminProductImageController extends Controller
{
    public function images($product_id):View{
        $images=ProductImage::where("product_id",$product_id)->orderBy("id","desc")->get();
        return view("admin.product_gallery",compact("images"));
    }
    
    public function image_store(Request $request){
        $request->validate([
            "product_id"=>"required|numeric|exists:products,id",
            "images"=>"required|array",
            "images.*"=>"file|mimes:jpg,jpeg,png|max:1048576",
        ]);

        $path=public_path("uploads/product-image/");

        if(!is_dir($path))
            mkdir($path,0577,true);

        foreach($request->file("images") as $file) {
            $tmp=$file->getPathname();
            $extension=strtolower($file->getClientOriginalExtension());
            $image=uniqid().".".$extension;

            list($width,$height)=getimagesize($tmp);
            $thumbnail=imagecreatetruecolor($width,$height);

            switch($extension){
                case "jpg": case "jpeg": $source_img=imagecreatefromjpeg($tmp);break;
                case "png": $source_img=imagecreatefrompng($tmp);break;
                default: return redirect()->back()->with("error","Invalid image format.");
            }

            imagecopyresampled($thumbnail,$source_img,0,0,0,0,$width,$height,$width,$height);

            switch($extension){
                case "jpg": case "jpeg": imagejpeg($thumbnail,$path.$image,90);break;
                case "png": imagepng($thumbnail,$path.$image,9);break;
            }

            imagedestroy($thumbnail);
            imagedestroy($source_img);

            $product_image = new ProductImage();
            $product_image->image=$image;
            $product_image->product_id=$request->product_id;

            if(!$product_image->save())
                return redirect()->back()->with("error","Failed to save the image.");
        }

        return redirect()->back()->with("success","Image uploaded successfully.");
    }
    public function image_update(Request $request){
        $validator=\Validator::make($request->all(),[
            "product_id"=>"required|numeric|exists:products,id",
            "image_id"=>"required|numeric|exists:product_images,id",
            "image"=>"required|file|mimes:jpg,jpeg,png|max:1048576",
        ]);

        if(!$validator->passes())
            return response()->json(["error"=>["message"=>$validator->errors()->first()]]);

        $product_image=ProductImage::
            where("id",$request->image_id)->
            where("product_id",$request->product_id)->
            first();

        if(!$product_image)
            return response()->json(["error"=>["message"=>"Image not found."]]);

        if($request->hasFile("image")){
            $path=public_path("uploads/product-image/");
            $tmp=$request->file("image")->getPathname();
            $extension=strtolower($request->file("image")->getClientOriginalExtension());
            $image=uniqid().".".$extension;

            if(!is_dir($path))
                mkdir($path,0577,true);

            if(is_file($path.$product_image->image))
                unlink($path.$product_image->image);

            list($width,$height)=getimagesize($tmp);
            $thumbnail=imagecreatetruecolor($width,$height);

            switch($extension){
                case "jpg": case "jpeg": $source_img=imagecreatefromjpeg($tmp);break;
                case "png": $source_img=imagecreatefrompng($tmp);break;
                default: return response()->json(["error"=>["message"=>"Failed to update image."]]);
            }

            imagecopyresampled($thumbnail,$source_img,0,0,0,0,$width,$height,$width,$height);

            switch($extension){
                case "jpg": case "jpeg": imagejpeg($thumbnail,$path.$image,90);break;
                case "png": imagepng($thumbnail,$path.$image,9);break;
            }

            imagedestroy($thumbnail);
            imagedestroy($source_img);

            $product_image->image=$image;
        }

        if(!$product_image->save())
            return response()->json(["error"=>["message"=>"Failed to update image."]]);

        return response()->json(["success"=>["message"=>"Image updated successfully."]]);
    }
    public function image_status_update(Request $request){
        $validator=\Validator::make($request->all(),[
            "product_id"=>"required|numeric|exists:products,id",
            "image_id"=>"required|numeric|exists:product_images,id",
        ]);

        if(!$validator->passes())
            return response()->json(["error"=>["message"=>$validator->errors()->first()]]);

        $product_image=ProductImage::
            where("id",$request->image_id)->
            where("product_id",$request->product_id)->
            first();

        if(!$product_image)
            return response()->json(["error"=>["message"=>"Image not found."]]);

        $product_image->status=$request->status;

        if(!$product_image->save())
            return response()->json(["error"=>["message"=>"Failed to update the image status."]]);

        return response()->json(["success"=>["message"=>"Image status updated successfully."]]);
    }
    public function image_delete(Request $request){
        $validator=\Validator::make($request->all(),[
            "product_id"=>"required|numeric|exists:products,id",
            "image_id"=>"required|numeric|exists:product_images,id",
        ]);

        if(!$validator->passes())
            return response()->json(["error"=>["message"=>$validator->errors()->first()]]);

        $product_image=ProductImage::
            where("id",$request->image_id)->
            where("product_id",$request->product_id)->
            first();

        if(!$product_image)
            return response()->json(["error"=>["message"=>"Image not found."]]);

        $path=public_path("uploads/product-image/");

        if(is_file($path.$product_image->image))
            unlink($path.$product_image->image);

        if(!$product_image->delete())
            return response()->json(["error"=>["message"=>"Failed to delete the image."]]);

        return response()->json(["success"=>["message"=>"Image deleted successfully."]]);
    }
}
