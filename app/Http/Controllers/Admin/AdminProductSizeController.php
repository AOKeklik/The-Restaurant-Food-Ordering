<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductSizes;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminProductSizeController extends Controller
{
    public function sizes($product_id):View{
        $sizes=ProductSizes::where("product_id",$product_id)->orderBy("id","desc")->get();
        return view("admin.product_sizes",compact("sizes"));
    }
    public function size_edit($size_id):View{
        $size=ProductSizes::find($size_id);
        return view("admin.product_size_edit",compact("size"));
    }
    
    public function size_store(Request $request){
        $request->validate([
            "product_id"=>"required|numeric|exists:products,id",
            "price"=>"required|numeric",
            "name" => "required|string"
        ]);

        $product_size=new ProductSizes();

        $product_size->name=$request->name;
        $product_size->price=$request->price;
        $product_size->product_id =$request->product_id;

        if(!$product_size->save())
            return redirect()->back()->with("error","Failed to create size.");

        return redirect()->back()->with("success","Size created successfully.");
    }
    public function size_update(Request $request){
        $request->validate([
            "product_id"=>"required|numeric|exists:products,id",
            "size_id"=>"required|numeric|exists:product_sizes,id",
            "price"=>"required|numeric",
            "name" => "required|string"
        ]);

        $product_size=ProductSizes::
            where("id",$request->size_id)->
            where("product_id",$request->product_id)->
            first();

        if(!$product_size)
            return redirect()->back()->with("error","Size not found.");

        $product_size->name=$request->name;
        $product_size->price=$request->price;

        if(!$product_size->save())
            return redirect()->back()->with("error","Failed to update size.");

        return redirect()->route("admin.product.sizes",["product_id"=> $product_size->product_id])->with("success","Size updated successfully.");
    }
    public function size_status_update(Request $request){
        $validator=\Validator::make($request->all(),[
            "product_id"=>"required|numeric|exists:products,id",
            "size_id"=>"required|numeric|exists:product_sizes,id",
        ]);

        if(!$validator->passes())
            return response()->json(["error"=>["message"=>$validator->errors()->first()]]);

        $product_size=ProductSizes::
            where("id",$request->size_id)->
            where("product_id",$request->product_id)->
            first();

        if(!$product_size)
            return response()->json(["error"=>["message"=>"Size not found."]]);

        $product_size->status=$request->status;

        if(!$product_size->save())
            return response()->json(["error"=>["message"=>"Failed to update the size status."]]);

        return response()->json(["success"=>["message"=>"Image Size updated successfully."]]);
    }
    public function size_delete(Request $request){
        try{
            $validator=\Validator::make($request->all(),[
                "product_id"=>"required|numeric|exists:products,id",
                "size_id"=>"required|numeric|exists:product_sizes,id",
            ]);
    
            if(!$validator->passes())
                return response()->json(["error"=>["message"=>$validator->errors()->first()]]);
    
            $product_size=ProductSizes::
                where("id",$request->size_id)->
                where("product_id",$request->product_id)->
                first();
    
            if(!$product_size)
                return response()->json(["error"=>["message"=>"Size not found."]]);
    
    
            if(!$product_size->delete())
                return response()->json(["error"=>["message"=>"Failed to delete the size."]]);
    
            return response()->json(["success"=>["message"=>"Size deleted successfully."]]);
        } catch(\Exception $err){
            return response()->json(["error"=>["message"=>$err->getMessage()]]);
        }
    }
}
