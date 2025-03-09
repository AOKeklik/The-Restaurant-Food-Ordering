<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryArea;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class AdminDeliveryAreasController extends Controller
{
    public function delivery_areas ():View {
        $deliveryAreas=DeliveryArea::orderBy("id","DESC")->get();
        return view("admin.delivery_areas.index",compact("deliveryAreas"));
    }
    public function delivery_area_add ():View {
        return view("admin.delivery_areas.add");
    }
    public function delivery_area_edit ($coupon_id):View {
        $deliveryArea=DeliveryArea::find($coupon_id);
        return view("admin.delivery_areas.edit",compact("deliveryArea"));
    }


    public function delivery_area_store (Request $request) {
        $request->validate([
            "name"=>"required|string",
            "min_time"=>"nullable|numeric",
            "max_time"=>"nullable|numeric",
            "fee"=>"nullable|numeric",
        ]);

        $delivery_area=new DeliveryArea();

        $delivery_area->name=$request->name;

        if($request->min_time) $delivery_area->min_time=$request->min_time;
        if($request->max_time) $delivery_area->max_time=$request->max_time;
        if($request->fee) $delivery_area->fee=$request->fee;

        if(!$delivery_area->save())
            return redirect()->back()->with("error","Failed to save Delivery Area.");

        return redirect()->route("admin.delivery_areas")->with("success"," Delivery Area created successfully.");
    }
    public function delivery_area_update (Request $request) {
        $request->validate([
            "delivery_area_id"=>"required|numeric",
            "name"=>"required|string",
            "min_time"=>"nullable|numeric",
            "max_time"=>"nullable|numeric",
            "fee"=>"nullable|numeric",
        ]);

        $delivery_area= DeliveryArea::find($request->delivery_area_id);

        $delivery_area->name=$request->name;

        if($request->min_time) $delivery_area->min_time=$request->min_time;
        if($request->max_time) $delivery_area->max_time=$request->max_time;
        if($request->fee) $delivery_area->fee=$request->fee;

        if(!$delivery_area->save())
            return redirect()->back()->with("error","Failed to save Delivery Area.");

        return redirect()->route("admin.delivery_areas")->with("success","Delivery Area updated successfully.");
    }
    public function delivery_area_ajax_status_update (Request $request) {
        $validator = \Validator::make($request->all(), [
            "delivery_area_id"=>"required|numeric",
            "status"=>"required|numeric|in:1,0"
        ]);

        if(!$validator->passes())
            return response()->json(["error"=>["message"=>$validator->errors()->first()]]);

        $delivery_area= DeliveryArea::find($request->delivery_area_id);

        if(!$delivery_area)
            return response()->json(["error"=>["message"=>"Delivery Area not found."]]);

        $delivery_area->status=$request->status;

        if(!$delivery_area->save())
            return response()->json(["error"=>["message"=>"Failed to update Delivery Area status."]]);

        return response()->json(["success"=>["message"=>"Delivery Area status updated successfully."]]);
    }
    public function delivery_area_ajax_delete (Request $request) {
        $validator = \Validator::make($request->all(), [
            "delivery_area_id"=>"required|numeric",
        ]);

        if(!$validator->passes())
            return response()->json(["error"=>["message"=>$validator->errors()->first()]]);

        $delivery_area=DeliveryArea::find($request->delivery_area_id);

        if(!$delivery_area)
            return response()->json(["error"=>["message"=>"Delivery Area not found."]]);

        if(!$delivery_area->delete())
            return response()->json(["error"=>["message"=>"Failed to delete Delivery Area status."]]);

        return response()->json(["success"=>["message"=>"Delivery Area deleted successfully."]]);
    }
}
