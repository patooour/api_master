<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    use GeneralTrait;

    public function index(){
       $cats =  Category::select('id' ,'name_'. app()->getLocale() .' as name')->get();



        return $this->returnData('data' , $cats , '');
    }

    public function CatId(Request $request){
        $cats =  Category::select('id' ,'name_'. app()->getLocale() .' as name')
            ->find($request->id);

        if (!$cats){
            return $this->returnError('0001' , 'id not found');
        }else{
            return $this->returnData('data' , $cats,'successfully');

        }

    }

    public function changeStatus(Request $request){

        Category::where('id', $request->id)->update(['active' => $request->active]);

        return $this->returnSuccess('update successfully');
    }
    public function profile(){
        return response()->json(['msg'=>'succes auth ']);
    }

}
