<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\Websitemail;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    public function signup():View{
        return view("front.auth_signup");
    }
    public function signin():View{
        return view("front.auth_signin");
    }
    public function forget():View{
        return view("front.auth_forget");
    }
    public function reset(Request $request):View{
        $email=$request->email;
        $token=$request->token;

        return view("front.auth_reset",compact("email","token"));
    }

    public function signup_submit(Request $request){
        $request->validate([
            "name"=>"required|string|min:3|max:15",
            "email"=>"required|email|unique:users,email",
            "password"=>"required|string|min:8|max:13",
            "confirm-password"=>"required|same:password",
        ]);

        try{    
            $customer=new User();
            $token=bin2hex(random_bytes(32/2));
            $hashed_token=password_hash($token,PASSWORD_DEFAULT);
            $link = url("customer/signup/verify/submit?token=".$hashed_token."&email=".$request->email);
    
            $customer->name=$request->name;
            $customer->email=$request->email;
            $customer->password=password_hash($request->password,PASSWORD_DEFAULT);
            $customer->remember_token=$token;
    
            if(!$customer->save())
                throw new Exception("An error occurred while saving the customer.");
    
            $subject="Verify Signup Form - ".config("app.name");
            $body="<p>Dear <strong>".$request->name."</strong></p>";
            $body.="<p>Please click on the following link: <br>";
            $body.="<a href='$link'>Click!</a></p>";
            $body.="<p>Thank you,</p>";
            $body.="<p><strong>".config("app.name")."</strong> Team</p>";
    
            \Mail::to($request->email)->send(new Websitemail($subject,$body));
    
            return redirect()->route("front.customer.signin")->with("success","Verification email sent. Please check your inbox.");
        }catch(\Exception $err){
            return redirect()->back()->with("error",$err->getMessage());
        }
    }
    public function signup_verify_submit(Request $request){
        try{
            $customer=User::where("email",$request->email)->first();

            if(!$customer)
                throw new Exception("No account associated with this email.");

            if(!password_verify($customer->remember_token,$request->token))
                throw new Exception("Invalid or expired verification token.");

            $customer->remember_token=null;
            $customer->status=1;
            $customer->email_verified_at=now();

            if(!$customer->update())
                throw new Exception("An error occurred while updating the user status.");
                
            return redirect()->route("front.customer.signin")->with("success","Your account has been successfully verified. Please log in.");
        }catch(\Exception $err){
            return redirect()->route("front.customer.signin")->with("error",$err->getMessage());
        }
    }
    public function signin_submit(Request $request){
        $request->validate([
            "email"=>"required|email|exists:users,email",
            "password"=>"required|string|min:8|max:13",
        ]);

        try{
            $credential=[
                "email"=>$request->email,
                "password"=>$request->password,
                "status"=>1,
            ];

            if(!Auth::guard("user")->attempt($credential))
                throw new Exception("Invalid credentials or account is not active.");


            return redirect()->route("front.customer.dashboard")->with("success","Welcome back!");
        }catch(\Exception $err){
            return redirect()->back()->with("error",$err->getMessage());
        }
    }
    public function forget_submit(Request $request){
        $request->validate([
            "email"=>"required|email|exists:users,email",
        ]);

        try{
            $token=bin2hex(random_bytes(32/2));
            $hashed_token=password_hash($token,PASSWORD_DEFAULT);
            $link=url("customer/reset?token=".$hashed_token."&email=".$request->email);
            $customer=User::where("email",$request->email)->first();

            if(!$customer)
                throw new Exception("User not found.");


            $customer->status=0;
            $customer->remember_token=$token;
            $customer->save();

            $subject="Password Reset Request - ".config("app.name");
            $body="<p>Dear <strong>".htmlspecialchars($customer->name)."</strong></p>";
            $body.="<p>Please click on the following link: <br>";
            $body.="<a href='$link'>Click!</a></p>";
            $body.="<p>Thank you,</p>";
            $body.="<p><strong>".config("app.name")."</strong> Team</p>";

            \Mail::to($request->email)->send(new Websitemail($subject,$body));

            return redirect()->route("front.customer.signin")->with("success","Password reset instructions have been sent to your email.");
        }catch(Exception $err){
            return redirect()->back()->with("error",$err->getMessage());
        }
    }
    public function reset_submit(Request $request){
        $request->validate([
            "email"=>"required|email|exists:users,email",
            "token"=>"required|string",
            "password"=>"required|string|min:8|max:13",
            "confirm-password"=>"required|same:password",
        ]);

        try{
            $customer=User::where("email",$request->email)->first();

            if(!$customer)
                throw new Exception("User not found.");
            
            if(!password_verify($customer->remember_token,$request->token))
                throw new Exception("Invalid or expired token.");

            $customer->password=password_hash($request->password,PASSWORD_DEFAULT);
            $customer->remember_token=null;
            $customer->status=1;
            $customer->email_verified_at=now();
            
            if(!$customer->update())
                throw new Exception("Failed to update user information.");

            return redirect()->route("front.customer.signin")->with("success","Password has been successfully reset. Please sign in.");
        }catch(Exception $err){
            return redirect()->back()->with("error",$err->getMessage());
        }
    }
    public function signout_submit(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route("front.customer.signin")->with("success","Successfully logged out.");
    }
}
