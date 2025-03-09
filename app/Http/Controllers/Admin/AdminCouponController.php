<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;

class AdminCouponController extends Controller
{
    public function coupons ():View {
        $coupons=Coupon::orderBy("id","DESC")->get();
        return view("admin.coupons",compact("coupons"));
    }
    public function coupon_add ():View {
        $coupons=Coupon::orderBy("id","DESC")->get();
        return view("admin.coupon_add",compact("coupons"));
    }
    public function coupon_edit ($coupon_id):View {
        $coupons=Coupon::orderBy("id","DESC")->get();
        $coupon=Coupon::find($coupon_id);
        return view("admin.coupon_edit",compact("coupon","coupons"));
    }


    public function coupon_store (Request $request) {
        $request->validate([
            "name"=>"required|string|unique:coupons,name",
            "code"=>"required|string|unique:coupons,code|min:6|max:15",
            "quantity"=>"required|numeric",
            "min_purchase_amount"=>"required|numeric",
            "expire_date"=>"required|date",
            "discount_type"=>"nullable|string|in:percent,amount",
            "discount"=>"required|numeric",
        ]);

        $coupon=new Coupon();

        $coupon->name=$request->name;
        $coupon->code=strtoupper($request->code);
        $coupon->quantity=$request->quantity;
        $coupon->min_purchase_amount=$request->min_purchase_amount;
        $coupon->expire_date=$request->expire_date;

        if($request->discount_type)
            $coupon->discount_type=$request->discount_type;

        $coupon->discount=$request->discount;

        if(!$coupon->save())
            return redirect()->back()->with("error","Failed to save coupon.");

        return redirect()->route("admin.coupons")->with("success","Coupon created successfully.");
    }
    public function coupon_update (Request $request) {
        $request->validate([
            "coupon_id"=>"required|numeric|unique:coupons,name",
            "name"=>[
                "required",
                "string",
                Rule::unique("coupons","name")->ignore($request->coupon_id),
            ],
            "code"=>[
                "required",
                "string",
                "min:5",
                "max:15",
                Rule::unique("coupons","code")->ignore($request->coupon_id)
            ],
            "quantity"=>"required|numeric",
            "min_purchase_amount"=>"required|numeric",
            "expire_date"=>"required|date",
            "discount_type"=>"nullable|string|in:percent,amount",
            "discount"=>"required|numeric",
        ]);

        $coupon=Coupon::find($request->coupon_id);

        $coupon->name=$request->name;
        $coupon->code=strtoupper($request->code);
        $coupon->quantity=$request->quantity;
        $coupon->min_purchase_amount=$request->min_purchase_amount;
        $coupon->expire_date=$request->expire_date;

        if(!empty($coupon->discount_type))
            $coupon->discount_type=$request->discount_type;

        $coupon->discount=$request->discount;

        if(!$coupon->save())
            return redirect()->back()->with("error","Failed to save coupon.");

        return redirect()->route("admin.coupons")->with("success","Coupon updated successfully.");
    }
    public function coupon_ajax_status_update (Request $request) {
        $validator = \Validator::make($request->all(), [
            "coupon_id"=>"required|numeric|exists:coupons,id",
            "status"=>"required|numeric|in:1,0"
        ]);

        if(!$validator->passes())
            return response()->json(["error"=>["message"=>$validator->errors()->first()]]);

        $coupon=Coupon::find($request->coupon_id);

        if(!$coupon)
            return response()->json(["error"=>["message"=>"Coupon not found."]]);

        $coupon->status=$request->status;

        if(!$coupon->save())
            return response()->json(["error"=>["message"=>"Failed to update coupon status."]]);

        return response()->json(["success"=>["message"=>"Coupon status updated successfully."]]);
    }
    public function coupon_ajax_delete (Request $request) {
        $validator = \Validator::make($request->all(), [
            "coupon_id"=>"required|numeric|exists:coupons,id",
        ]);

        if(!$validator->passes())
            return response()->json(["error"=>["message"=>$validator->errors()->first()]]);

        $coupon=Coupon::find($request->coupon_id);

        if(!$coupon)
            return response()->json(["error"=>["message"=>"Coupon not found."]]);

        if(!$coupon->delete())
            return response()->json(["error"=>["message"=>"Failed to delete coupon status."]]);

        return response()->json(["success"=>["message"=>"Coupon deleted successfully."]]);
    }
}
