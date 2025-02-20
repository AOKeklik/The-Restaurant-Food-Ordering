<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSizes;
use Cocur\Slugify\Slugify;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function products ():View {
        $products=Product::orderBy("id","desc")->get();
        return view("admin.products",compact("products"));
    }
    public function product_add ():View {
        $categories=Category::where("status",1)->orderBy("id","desc")->get();
        $options=Option::where("status",1)->orderBy("id","desc")->get();

        return view("admin.product_add",compact("options","categories"));
    }
    public function product_edit ($product_id) {
        $categories=Category::where("status",1)->orderBy("id","desc")->get();
        $options=Option::where("status",1)->orderBy("id","desc")->get();
        $product=Product::find($product_id);

        if(!$product)
            return redirect()->route("admin.products")->with("error","Product not found!");

        return view("admin.product_edit",compact("options","categories","product"));
    }


    public function product_store (Request $request) {
        $request->validate([
            "category_id"=>"required|numeric|exists:categories,id",
            "name"=>"required|string",
            "price"=>"required|numeric",
            "offer_price"=>"nullable|numeric",
            "seo_title"=>"nullable|string",
            "seo_description"=>"nullable|string|",
            "image"=>"required|file|mimes:jpg,jpeg,png|max:1048576",
            "description"=>"required|string",
            "short_description"=>"nullable|string",
        ]);

        $slugify=new Slugify();
        $slug=$slugify->slugify($request->name);
        $sku="SKU-".strtoupper(substr(md5(uniqid()),0,8));

        $product=new Product();

        if($request->has("image")){
            $path=public_path("uploads/product/");
            $tmp=$request->file("image")->getPathname();
            $extentsion=strtolower($request->file("image")->getClientOriginalExtension());
            $image=uniqid().".".$extentsion;

            if(!is_dir($path))
                mkdir($path,0577,true);

            list($width,$height)=getimagesize($tmp);
            $thumbnail=imagecreatetruecolor($width,$height);

            switch($extentsion){
                case "jpg": case "jpeg": $source_img=imagecreatefromjpeg($tmp);break;
                case "png": $source_img=imagecreatefrompng($tmp);break;
                default: return redirect()->back()->with("error","Invalid image format.");
            }

            imagecopyresampled($thumbnail,$source_img,0,0,0,0,$width,$height,$width,$height);

            switch($extentsion){
                case "jpg": case "jpeg": imagejpeg($thumbnail,$path.$image,90);break;
                case "png": imagepng($thumbnail,$path.$image,9);break;
            }

            imagedestroy($thumbnail);
            imagedestroy($source_img);

            $product->image=$image;
        }

        $product->category_id=$request->category_id;
        $product->slug=$slug;
        $product->sku=$sku;
        $product->name=$request->name;
        $product->price=$request->price;

        if($request->offer_price)
            $product->offer_price=$request->offer_price;

        $product->seo_title=$request->seo_title;
        $product->seo_description=$request->seo_description;
        $product->description=$request->description;
        $product->short_description=$request->short_description;

        if(!$product->save())
            return redirect()->back()->with("error","Failed to save product.");

        return redirect()->route("admin.products")->with("success","Product created successfully.");
    }
    public function product_update (Request $request) {
        $request->validate([
            "product_id"=>"required|numeric|exists:products,id",
            "category_id"=>"required|numeric|exists:categories,id",
            "options"=>"nullable|array|exists:options,id",
            "name"=>"required|string",
            "price"=>"required|numeric",
            "offer_price"=>"nullable|numeric",
            "seo_title"=>"nullable|string",
            "seo_description"=>"nullable|string|",
            "image"=>"nullable|file|mimes:jpg,jpeg,png|max:1048576",
            "description"=>"required|string",
            "short_description"=>"nullable|string",
        ]);

        $slugify=new Slugify();
        $slug=$slugify->slugify($request->name);

        $product=Product::find($request->product_id);

        if(!$product)
            return redirect()->back()->with("error","Product not found.");

        if($request->hasFile("image")){
            $path=public_path("uploads/product/");
            $tmp=$request->file("image")->getPathname();
            $extentsion=strtolower($request->file("image")->getClientOriginalExtension());
            $image=uniqid().".".$extentsion;

            if(!is_dir($path))
                mkdir($path,0577,true);

            if(is_file($path.$product->image))
                unlink($path.$product->image);

            list($width,$height)=getimagesize($tmp);
            $thumbnail=imagecreatetruecolor($width,$height);

            switch($extentsion){
                case "jpg": case "jpeg": $source_img=imagecreatefromjpeg($tmp);break;
                case "png": $source_img=imagecreatefrompng($tmp);break;
                default: return redirect()->back()->with("error","Invalid image format.");
            }

            imagecopyresampled($thumbnail,$source_img,0,0,0,0,$width,$height,$width,$height);

            switch($extentsion){
                case "jpg": case "jpeg": imagejpeg($thumbnail,$path.$image,90);break;
                case "png": imagepng($thumbnail,$path.$image,9);break;
            }

            imagedestroy($thumbnail);
            imagedestroy($source_img);

            $product->image=$image;
        }

        $product->category_id=$request->category_id;
        $product->options=$request->has("options") ? implode(",",$request->options) : null;
        $product->slug=$slug;
        $product->name=$request->name;
        $product->price=$request->price;

        if($request->offer_price)
            $product->offer_price=$request->offer_price;

        $product->seo_title=$request->seo_title;
        $product->seo_description=$request->seo_description;
        $product->description=$request->description;
        $product->short_description=$request->short_description;

        if(!$product->save())
            return redirect()->back()->with("error","Failed to save product.");

        return redirect()->route("admin.products")->with("success","Product updated successfully.");
    }
    public function product_status_update (Request $request) {
        $validator = \Validator::make($request->all(), [
            "product_id" => "required|numeric|exists:products,id",
            "status" => "required|numeric|in:1,0",
        ]);

        if(!$validator->passes())
            return response()->json(["error" => ["message" => $validator->errors()->first()]]);

        $product=Product::find($request->product_id);

        if(!$product)
            return response()->json(["error"=>["message"=>"Product not found."]]);

        $product->status=$request->status;

        if(!$product->save())
            return response()->json(["error"=>["message"=>"Failed to update product status."]]);

        return response()->json(["success"=>["message"=>"Product status updated successfully."]]);
    }
    public function product_home_update (Request $request) {
        $validator = \Validator::make($request->all(), [
            "product_id" => "required|numeric|exists:products,id",
            "status" => "required|numeric|in:1,0",
        ]);

        if(!$validator->passes())
            return response()->json(["error" => ["message" => $validator->errors()->first()]]);

        $product=Product::find($request->product_id);

        if(!$product)
            return response()->json(["error"=>["message"=>"Product not found."]]);

        $product->show_on_homepage=$request->status;

        if(!$product->save())
            return response()->json(["error"=>["message"=>"Failed to update product status."]]);

        return response()->json(["success"=>["message"=>"Product status updated successfully."]]);
    }
    public function product_delete (Request $request) {
        $validator = \Validator::make($request->all(), [
            "product_id" => "required|numeric|exists:products,id"
        ]);

        if(!$validator->passes())
            return response()->json(["error" => ["message" => $validator->errors()->first()]]);

        $product=Product::find($request->product_id);

        if(!$product)
            return response()->json(["error"=>["message"=>"Product not found."]]);

        $product_images=ProductImage::where("product_id",$product->id)->get();

        if($product_images->count() > 0){
            foreach($product_images as $product_image) {
                if(is_file(public_path("uploads/product-image/").$product_image->image))
                    unlink(public_path("uploads/product-image/").$product_image->image);

                if(!$product_image->delete())
                    return response()->json(["error"=>["message"=>"Failed to delete the product image."]]);
            }
        }   

        $product_sizes=ProductSizes::where("product_id",$product->id)->get();

        if($product_sizes->count() > 0){
            foreach($product_sizes as $product_size) {
                if(!$product_size->delete())
                    return response()->json(["error"=>["message"=>"Failed to delete the product size."]]);
            }
        }  

        if(is_file(public_path("uploads/product/").$product->image))
            unlink(public_path("uploads/product/").$product->image);

        if(!$product->delete())
            return response()->json(["error"=>["message"=>"Failed to delete the product."]]);

        return response()->json(["success"=>["message"=>"The product deleted successfully."]]);
    }
}
