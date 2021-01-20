<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterFormRequest;
use App\Http\Requests\LoginFormRequest;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'birthdate'=>'required',
            'avatar' => 'required',
            'currency'=>'required',
            'password' => 'required|string|min:6|max:15|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|string|min:6|max:15',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => 'fail',
                'msg' => $validator->errors()->all(),
                'errors'=> [
                    'name'=> $errors->first('name'),
                    'email'=> $errors->first('email'),
                    'phone' => $errors->first('phone'),
                    'birthdate'=>$errors->first('birthdate'),
                    'currency'=>$errors->first('currency'),
                    'avatar'=>$errors->first('avatar'),
                    'password'=> $errors->first('password'),
                    'confirm_password'=> $errors->first('confirm_password'),
                ]
            ]);
        }
        if($request->avatar){

            $name = time().'.' . explode('/', explode(':', substr($request->avatar, 0, strpos($request->avatar, ';')))[1])[1];
            \Image::make($request->avatar)->save(public_path('img/profile/').$name);
            $request->merge(['avatar' => $name]);
           
        }
        $token = Str::random(60);
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;

        $user->phone = $request->phone;
        $user->birthdate = $request->birthdate;
        $user->currency = $request->currency;
        $user->avatar = $name;

        $user->password = bcrypt($request->password);
        $user->remember_token = $token;
        $user->save();

        if (isset($user->remember_token)) {
            $authUser = $user;

            return response()->json([
                'status' => 'success',
                'token' => $token,
                'userauth' => $authUser
            ], 200);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:15',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => 'fail',
                'msg' => $validator->errors()->all(),
                'errors'=> [
                    'email'=> $errors->first('email'),
                    'password'=> $errors->first('password'),
                ]
            ]);
        }

        $email = $request->email;
        $password = $request->password;

        $user = User::select('users.*','users.remember_token as token')->where('users.email', $request->email)
            ->first();
        if (!$user) {
            return response()->json([
                'status' => 'fail',
                'msg' => "Login Failed.Email doesn't register.",
                'errors'=> [
                    'email'=> "Email doesn't register.",
                    'password'=> "",
                ]
            ]);
        }else{
            if (!Hash::check($password, $user->password)) {
                return response()->json([
                    'status' => 'fail',
                    'msg' => "Password wrong.",
                    'errors'=> [
                        'email'=> "",
                        'password'=> "Password wrong.",
                    ]
                ]);
            }else{
                return response()->json([
                    'status'=>'success',
                    'message'=>'Login successfully.',
                    'userauth'=> $user
                ]);
            }
        }
    }
}
