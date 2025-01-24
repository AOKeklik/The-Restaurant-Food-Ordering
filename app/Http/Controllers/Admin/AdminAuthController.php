<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Websitemail;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login():View{
        return view("admin.auth_login");
    }
    public function forget():View{
        return view("admin.auth_forget");
    }
    public function login_submit(Request $request){
        $request->validate([
            "email"=>"required|email|exists:users,email",
            "password"=>"required|string|min:8",
        ]);

        $credential=[
            "email"=>$request->email,
            "password"=>$request->password,
            "status"=>1,
        ];

        if(!Auth::guard("user")->attempt($credential))
            return redirect()->back()->with("error","Not valid user or password!");
        
        return redirect()->route("admin.index")->with("success","Login successful!");
    }
    public function forget_submit(Request $request) {
        $request->validate([
            "email"=>"required|email|exists:users,email"
        ]);

        $admin = User::where("email",$request->email)->first();

        if(!$admin)
            return redirect()->back()->with("error","Please enter a valid email address!");

        $token = bin2hex(random_bytes(32/2));
        $hashed_token = password_hash($token, PASSWORD_DEFAULT);
        $reset_link = url("admin/reset?email=".$admin->email."&token=".$hashed_token);

        $admin->status=0;
        $admin->remember_token=$token;
        $admin->update();

        $subject="Reset Password";
        $message="Please click on the following link: <br>";
        $message.="<a href='$reset_link'>Click Here!</a>";

        \Mail::to($request->email)->send(new Websitemail($subject,$message));

        return redirect()->route("admin.login")->with("success","Please check your email and follow the steps there!");

    }
    public function reset(Request $request){
        $admin = User::where("email", $request->email)->first();

        if(!$admin)
            return redirect()->route("admin.login")->with("error","In valid email!");

        if(!password_verify($admin->remember_token,$request->token))
            return redirect()->route("admin.login")->with("error","In valid token!");

        return view("admin.auth_reset",["token"=>$request->token,"email"=>$request->email]);
    }
    public function reset_submit(Request $request){
        $request->validate([
            // "email"=>"required|email|exists:users,email",
            "password"=>"required|string|min:8|max:13",
            "confirm-password"=>"required|string|min:8|same:password",
            // "remember_token"=>"required|string",
        ]);

        $admin=User::where("email", $request->email)->first();

        if(!$admin)
            return redirect()->back()->with("error","Invalid email address or token!");

        if(!password_verify($admin->remember_token, $request->remember_token))
            return redirect()->back()->with("error","Invalid email address or token!");

        $admin->password=password_hash($request->password, PASSWORD_DEFAULT);
        $admin->remember_token=null;
        $admin->status=1;
        $admin->update();

        return redirect()->route("admin.login")->with("success","Password has been updated usccessfully!");
    }
    public function logout_submit(){
        Auth::guard("user")->logout();
        session()->flush();
        return redirect()->route("admin.login")->with("success","Successfully logged out.");
    }
}
