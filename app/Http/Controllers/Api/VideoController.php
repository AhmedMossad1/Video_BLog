<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\BackEnd\Videos\Store;
use App\Http\Resources\VideoResource;
use App\Models\Video;
use Illuminate\Http\Request;
class VideoController extends Controller
{
    public function index(){
        $video = VideoResource::collection(Video::get());
        $msg = ['ok'];
        return response($video,200,$msg);
    }
    public function show($id){
        $video = new VideoResource(Video::find($id));
        $msg = ['ok'];
        return response($video,200,$msg);
    }
    public function store(Store $request){
        $video = Video::create($request->all());
        $message1 = ['Video  created'];
        $message2 = ['Video Not Saved'];
        if($video){
            return response(new VideoResource($video),201,$message1);
        }
        return response(new VideoResource($video),400,$message2);
    }
    public function update(Request $request,$id){
        $video = Video::find($id);
        $video->update($request->all());
        $msg = ['Video Updated'];
        $msg2 = ['Not Save'];
        if($video){
        return response(new VideoResource($video),201,$msg);
        }
        return response(new VideoResource($video),400,$msg2);
    }
    public function destory($id){
        $video = Video::find($id);
        $video->delete($id);
        $msg = ['Deleted'];
        $msg2 = ['Not Saved'];
        if($video){
        return response(new VideoResource($video),201,$msg);
        }
        return response(new VideoResource($video),400,$msg2);
    }
}
