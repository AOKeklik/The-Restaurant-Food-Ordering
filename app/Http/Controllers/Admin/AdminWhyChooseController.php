<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhyChoose;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminWhyChooseController extends Controller
{
    public function why_chooses() :View{
        $whyChooses=WhyChoose::orderBy("id","desc")->get();
        return view("admin.setting_why_chooses",compact("whyChooses"));
    }
    public function why_choose_add() :View{
        return view("admin.setting_why_choose_add");
    }
    public function why_choose_edit($why_choose_id) :View{
        $whyChooses=WhyChoose::find($why_choose_id);

        if(!$whyChooses)
            return redirect()->route("admin.setting.why_chooses")->with("error","The why choose not found.");

        return view("admin.setting_why_choose_edit",compact("whyChooses"));
    }



    public function why_choose_store(Request $request) {
        $request->validate([
            "icon"=>"required|string",
            "title"=>"required|string",
            "description"=>"required|string",
        ]);

        $whyChoose=new WhyChoose();

        $whyChoose->icon=$request->icon;
        $whyChoose->title=$request->title;
        $whyChoose->description=$request->description;

        if(!$whyChoose->save())
            return redirect()->back()->with("error","Failed to save why choose."); 

        return redirect()->route("admin.setting.why_chooses")->with("success","Why choose added successfully.");
    }
    public function why_choose_update(Request $request) {
        $request->validate([
            "why_choose_id"=>"required|string|exists:why_chooses,id",
            "icon"=>"required|string",
            "title"=>"required|string",
            "description"=>"required|string",
        ]);

        $whyChoose=WhyChoose::find($request->why_choose_id);;

        $whyChoose->icon=$request->icon;
        $whyChoose->title=$request->title;
        $whyChoose->description=$request->description;

        if(!$whyChoose->save())
            return redirect()->back()->with("error","Failed to update why choose."); 

        return redirect()->route("admin.setting.why_chooses")->with("success","Why choose updated successfully.");
    }
    public function why_choose_status_update(Request $request){
        $validator = \Validator::make($request->all(), [
            "why_choose_id" => "required|numeric|exists:why_chooses,id",
            "status" => "required|numeric|in:1,0",
        ]);

        if(!$validator->passes())
            return response()->json(["error" => ["message" => $validator->errors()->first()]]);

        $WhyChoose=WhyChoose::find($request->why_choose_id);

        if(!$WhyChoose)
            return response()->json(["error"=>["message"=>"Why Choose not found."]]);

        $WhyChoose->status=$request->status;

        if(!$WhyChoose->save())
            return response()->json(["error"=>["message"=>"Failed to update Why Choose status."]]);

        return response()->json(["success"=>["message"=>"Why Choose status updated successfully."]]);
    }
    public function why_choose_delete(Request $request){
        $validator = \Validator::make($request->all(), [
            "why_choose_id" => "required|numeric|exists:why_chooses,id"
        ]);

        if(!$validator->passes())
            return response()->json(["error" => ["message" => $validator->errors()->first()]]);

        $whyChoose=WhyChoose::find($request->why_choose_id);

        if(!$whyChoose)
            return response()->json(["error"=>["message"=>"Why Choose not found."]]);


        if(!$whyChoose->delete())
            return response()->json(["error"=>["message"=>"Failed to delete the why choose."]]);

        return response()->json(["success"=>["message"=>"The why choose deleted successfully."]]);
    }
}
