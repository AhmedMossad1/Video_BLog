<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\BackEnd\Categories\Store;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
class CategoryController extends Controller
{
    public function index(){
        $category = CategoryResource::collection(Category::get());
        $msg = ['Ok'];
        return response($category,200,$msg);
    }
    public function show($id){
        $category = new CategoryResource(Category::find($id));
        $msg = ['Ok'];
        if($category){
            return response($category,200,$msg);
        }
        return response()->json(['message' => 'Category not found'], 404);
    }
    public function store(Store $request){
        $category = Category::create($request->all());
        $message1 = ['Category  created'];
        $message2 = ['Category Not Saved'];
        if($category){
            return response(new CategoryResource($category),201,$message1);
        }
        return response(new CategoryResource($category),400,$message2);
    }
    public function update(Request $request,$id){
        $category = Category::find($id);
        $category->update($request->all());
        $msg = ['Category Updated'];
        $msg2 = ['Not Save'];
        if($category){
        return response(new CategoryResource($category),201,$msg);
        }
        return response(new CategoryResource($category),400,$msg2);
    }
    public function destory($id){
        $category = Category::find($id);
        $category->delete($id);
        $msg = ['Deleted'];
        $msg2 = ['Not Saved'];
        if($category){
        return response(new CategoryResource($category),201,$msg);
        }
        return response(new CategoryResource($category),400,$msg2);
    }
}
