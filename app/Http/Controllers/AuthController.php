<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use GeneralTrait;
        public function getLogin(Request $request){

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

                $token = Auth::guard('admin-api')->attempt(['email' => $email , 'password' => $password]);

                if(!$token){
                    return $this->returnError('E001' , 'worng email or password');

                }
               $admin =  Auth::guard('admin-api')->user();
               $admin->api_token = $token;

                return $this->returnData('token' , $admin,'success');


            }catch (\Exception $exception){
                return $this->returnError($exception->getCode(),$exception->getMessage());
            }



        }
    public function logout(Request $request){
        $token =  $request->get('auth_token');

        if ($token){

            try {
                JWTAuth::setToken($token)->invalidate();
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('E001' , 'something went wrong');

            }

            return $this->returnSuccess('E001' , 'success logout');

        }else{
            return $this->returnError('E001' , 'something went wrong');
        }

    }

}
