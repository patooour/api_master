<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    use GeneralTrait;
    public function login (Request $request){

        try {
            $rules= [
                'email'=>'required',
                'password'=>'required'
            ];
            $validator = Validator::make($request->all(), $rules );

            if ($validator->fails() ) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code , $validator);
            }

            $email = $request->input('email');
            $password = $request->input('password');

            $token = Auth::guard('user-api')->attempt(['email' => $email , 'password' => $password]);

            if(!$token){
                return $this->returnError('E001' , 'wrong email or password');

            }
            $admin =  Auth::guard('user-api')->user();
            $admin->api_token = $token;

            return $this->returnData('token' , $admin,'success');


        }catch (\Exception $exception){
            return $this->returnError($exception->getCode(),$exception->getMessage());
        }



    }
}
