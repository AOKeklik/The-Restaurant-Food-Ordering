<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\DeliveryArea;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FrontCustomerProfileController extends Controller
{
    public function dashboard () : View {
        $addresses=Address::
            where("user_id",Auth::guard("user")->user()->id)->
            orderBy("id","desc")->
            get();
        $deliveryAreas=DeliveryArea::where("status",1)->orderBy("id","desc")->get();
        return view("front.customer-dashboard.index",compact("addresses","deliveryAreas"));
    }

    public function avatar_update (Request $request) {
        $request->validate([
            "avatar"=>"required|file|mimes:jpg,png,jpeg|max:1048576",
        ]);

        $customer=User::find(Auth::guard("user")->user()->id);

        if(!$customer)
            return redirect()->back()->with("error","User not found.");

        if(!is_dir(public_path("uploads/customer/")))
            mkdir(public_path("uploads/customer/"),0577,true);

        if(strpos($customer->avatar,"avatar") === false && is_file(public_path("uploads/customer/").$customer->avatar))
            unlink(public_path("uploads/customer/").$customer->avatar);

        $avatar=uniqid().".".$request->file("avatar")->getClientOriginalExtension();

        list($width,$height)=getimagesize($request->file("avatar")->getPathname());
        $thumbnail=imagecreatetruecolor($width,$height);

        switch($request->file("avatar")->getClientOriginalExtension()){
            case "jpg": case "jpeg": $source_image=imagecreatefromjpeg($request->file("avatar")->getPathname());break;
            case "png": $source_image=imagecreatefrompng($request->file("avatar")->getPathname());break;
            default: redirect()->back()->with("error","Invalid image format.");
        }

        imagecopyresampled($thumbnail,$source_image,0,0,0,0,$width,$height,$width,$height);
        imagejpeg($thumbnail,public_path("uploads/customer/").$avatar,90);

        imagedestroy($thumbnail);
        imagedestroy($source_image);

        $customer->avatar=$avatar;

        if(!$customer->update())
            return redirect()->back()->with("error","Failed to update avatar.");

        return redirect()->back()->with("success","Avatar updated successfully.");
    }
    public function password_update (Request $request) {
        $request->validate([
            "current_password"=>"required|string",
            "password"=>"required|string|min:7|max:13",
            "confirm_password"=>"required|string|same:password"
        ]);

        $customer=User::find(Auth::guard("user")->user()->id);

        if(!$customer)
            return redirect()->back()->with("error","User not found.");

        if(!password_verify($request->current_password,$customer->password))
            return redirect()->back()->with("error","Current password is incorrect.");

        $customer->password=password_hash($request->password,PASSWORD_DEFAULT);

        if(!$customer->update())
            return redirect()->back()->with("error","Failed to update the password.");

        return redirect()->back()->with("success","Password updated successfully.");
    }

    /* profile */
    public function profile_info_ajax() {
        return view("front.customer-dashboard.profile_info_ajax");
    }
    public function profile_edit_ajax() {
        return view("front.customer-dashboard.profile_edit_ajax");
    }
    public function profile_update_ajax (Request $request) {
        $validator = \Validator::make($request->all(),[
            "name"=>"required|string",
            "email"=>[
                "required",
                "email",
                Rule::unique("users","email")->ignore(Auth::guard('user')->user()->id)
            ],
        ]);

        if(!$validator->passes())
            return response()->json(["error"=>["message"=>$validator->errors()->toArray()]]);

        $customer=User::find(Auth::guard("user")->user()->id);

        if(!$customer)
            return redirect()->back()->with("error","User not found.");

        $customer->name=$request->name;
        $customer->email=$request->email;

        if(!$customer->update())
            return response()->json(["error"=>["message"=>"Failed to update profile."]]);
        
        return response()->json(["success"=>["message"=>"Profile updated successfully."]]);
    }

    /* address */
    public function address_store_ajax (Request $request) {
        try{
            $validator = \Validator::make($request->all(),[
                "user_id"=>"required|numeric|exists:users,id",
                "first_name"=>"required|string",
                "last_name"=>"nullable|string",
                "phone"=>"required",
                "email"=>"required|email",
                "delivery_area_id"=>"required|exists:delivery_areas,id",
                "address"=>"required",
                "type"=>"required|string|in:home,office",
            ]);

            if(!$validator->passes())
                return response()->json(["error_form"=>["message"=>$validator->errors()->toArray()]]);


            $addresses=Address::where('user_id', $request->user_id)->get();

            if($addresses->count() >= 4)
                return response()->json(["error"=>["message"=>"You can only have 4 addresses."]]);

            $address=new Address();

            $address->user_id=$request->user_id;
            $address->delivery_area_id=$request->delivery_area_id;
            $address->type=$request->type;
            $address->first_name=$request->first_name;
            if($request->last_name) $address->last_name=$request->last_name;
            $address->email=$request->email;
            $address->phone=$request->phone;
            $address->address=$request->address;

            if(!$address->save())
                return  response()->json(["error"=>["message"=>"Failed to create address."]]);
            
            return response()->json(["success"=>["message"=>"Address created successfully."]]);
        }catch(\Exception $err){
            return response()->json(["error"=>["message"=>$err->getMessage()]]);
        }
    }
    public function address_items_ajax () {
        $addresses=Address::orderBy("id","DESC")->get();
        return view("front.customer-dashboard.address_items_ajax",compact("addresses"));
    }
    public function address_edit_ajax (Request $request) {
        try{
            $validator = \Validator::make($request->all(),[
                "address_id"=>"required|numeric|exists:addresses,id",
            ]);

            if(!$validator->passes())
                return response()->json(["error"=>["message"=>$validator->errors()->first()]]);

            $address=Address::find($request->address_id);

            if (!$address)
                return response()->json(["error"=>["message"=>"Address not found."]]);

            $deliveryAreas=DeliveryArea::orderBy("id","desc")->get();
            
            return view("front.customer-dashboard.address_edit_ajax",compact("address","deliveryAreas"));
        }catch(\Exception $err){
            return response()->json(["error"=>["message"=>$err->getMessage()]]);
        }
    }
    public function address_update_ajax (Request $request) {
        try{
            $validator = \Validator::make($request->all(),[
                "address_id"=>"required|numeric|exists:addresses,id",
                "first_name"=>"required|string",
                "last_name"=>"nullable|string",
                "phone"=>"required",
                "email"=>"required|email",
                "delivery_area_id"=>"required|exists:delivery_areas,id",
                "address"=>"required",
                "type"=>"required|string|in:home,office",
            ]);

            if(!$validator->passes())
                return response()->json(["error"=>["message"=>$validator->errors()->toArray()]]);

            $address=Address::find($request->address_id);

            if(!$address)
                return redirect()->back()->with("error","Address not found.");

            $address->user_id=$request->user_id;
            $address->delivery_area_id=$request->delivery_area_id;
            $address->type=$request->type;
            $address->first_name=$request->first_name;
            if($request->last_name) $address->last_name=$request->last_name;
            $address->email=$request->email;
            $address->phone=$request->phone;
            $address->address=$request->address;

            if(!$address->save())
                return redirect()->back()->with("error","Failed to update address.");
            
            return response()->json(["success"=>["message"=>"Address updated successfully."]]);
        }catch(\Exception $err){
            return response()->json(["error"=>["message"=>$err->getMessage()]]);
        }
    }
    public function address_delete_ajax (Request $request) {
        try{
            $validator = \Validator::make($request->all(),[
                "address_id"=>"required|numeric|exists:addresses,id",
            ]);

            if(!$validator->passes())
                return response()->json(["error"=>["message"=>$validator->errors()->first()]]);

            $address=Address::find($request->address_id);

            if(!$address)
                return redirect()->back()->with("error","Address not found.");

            if(!$address->delete())
                return redirect()->back()->with("error","Failed to delete address.");
            
            return response()->json(["success"=>["message"=>"Address deleted successfully."]]);
        }catch(\Exception $err){
            return response()->json(["error"=>["message"=>$err->getMessage()]]);
        }
    }
}
