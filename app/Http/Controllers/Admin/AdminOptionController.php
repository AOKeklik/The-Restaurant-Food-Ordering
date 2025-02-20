<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminOptionController extends Controller
{
    public function options ():View {
        $options=Option::orderBy("id","DESC")->get();
        return view("admin.options",compact("options"));
    }
    public function option_add ():View {
        $options=Option::orderBy("id","DESC")->get();
        return view("admin.option_add",compact("options"));
    }
    public function option_edit ($option_id):View {
        $options=Option::orderBy("id","DESC")->get();
        $option=Option::find($option_id);
        return view("admin.option_edit",compact("option","options"));
    }


    public function option_store (Request $request) {
        $request->validate([
            "name"=>"required|string|unique:options,name",
            "price"=>"required|numeric",
        ]);

        $option=new Option();

        $option->name=$request->name;
        $option->price=$request->price;

        if(!$option->save())
            return redirect()->back()->with("error","Failed to save option.");

        return redirect()->route("admin.options")->with("success","Option created successfully.");
    }
    public function option_update (Request $request) {
        $request->validate([
            "option_id"=>"required|numeric|unique:options,name",
            "name"=>[
                "required",
                "string",
                Rule::unique("options","name")->ignore($request->option_id),
            ],
            "price"=>"required|numeric",
        ]);

        $option=Option::find($request->option_id);

        if(!$option)
            return redirect()->back()->with("error","Option not found.");

        $option->name=$request->name;
        $option->price=$request->price;

        if(!$option->save())
            return redirect()->back()->with("error","Failed to save option.");

        return redirect()->route("admin.options")->with("success","Option updated successfully.");
    }
    public function option_status_update (Request $request) {
        $validator = \Validator::make($request->all(), [
            "option_id"=>"required|numeric|exists:options,id",
            "status"=>"required|numeric|in:1,0"
        ]);

        if(!$validator->passes())
            return response()->json(["error"=>["message"=>$validator->errors()->first()]]);

        $option=Option::find($request->option_id);

        if(!$option)
            return response()->json(["error"=>["message"=>"Option not found."]]);

        $option->status=$request->status;

        if(!$option->save())
            return response()->json(["error"=>["message"=>"Failed to update option status."]]);

        return response()->json(["success"=>["message"=>"Option status updated successfully."]]);
    }
    public function option_delete (Request $request) {
        $validator = \Validator::make($request->all(), [
            "option_id"=>"required|numeric|exists:options,id",
        ]);

        if(!$validator->passes())
            return response()->json(["error"=>["message"=>$validator->errors()->first()]]);

        $option=Option::find($request->option_id);

        if(!$option)
            return response()->json(["error"=>["message"=>"Option not found."]]);

        if(!$option->delete())
            return response()->json(["error"=>["message"=>"Failed to delete option status."]]);

        return response()->json(["success"=>["message"=>"Option deleted successfully."]]);
    }
}
