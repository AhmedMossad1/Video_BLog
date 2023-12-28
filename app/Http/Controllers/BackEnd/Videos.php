<?php
namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Http\Requests\BackEnd\Videos\Store;
use App\Http\Requests\BackEnd\Videos\Update;
use App\Models\Skill;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use App\Notifications\AddVideo;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class Videos extends BackEndController
{
    use CommentTrait;
    public function __construct(Video $model){
        parent::__construct($model);
    }
    protected function with(){
        return['cat','user'];
    }
    protected function append(){
        $array= [
            'categories' => Category::get(),
            'skills' => Skill::get(),
            'tags' => Tag::get(),
            'selectedSkills' =>[],
            'selectedTags' => [],
            'comments'=> []
        ];
        if (request()->route()->parameter('video')){
            $array['selectedSkills']=$this->model->find(request()->route()->parameter('video'))
            ->skills->pluck('id')->toArray();
            $array['selectedTags']=$this->model->find(request()->route()->parameter('video'))
            ->tags->pluck('id')->toArray();
            $array['comments']=$this->model->find(request()->route()->parameter('video'))
            ->comments()->orderBy('id','desc')->with('user')->get();

        }
        return $array;
    }
    public function store(Store $request){
        $fileName = $this->uploadImage($request);
        $requestarray =$request->all();
        $requestarray =  ['user_id' => auth()->user()->id , 'image' => $fileName] + $requestarray;
        $row= $this->model::create($requestarray);
        $this->syncTagsSkills($row , $requestarray);
        $users = User::where('id','!=',auth()->user()->id)->get();
        $user_create = auth()->user()->name;
        Notification::send($users,new AddVideo($row->id,$user_create,$row->name));
        return redirect()->route('videos.index');
    }
    public function update($id,Update $request){
        $requestarray = $request->all();
        if($request->hasFile('image')){
            $fileName = $this->uploadImage($request);
            $requestarray = ['image' => $fileName] + $requestarray;
        }
        $row= $this->model->findOrFail($id);
        $this->syncTagsSkills($row , $requestarray);
        return redirect()->route('videos.index');
    }
    protected function syncTagsSkills($row , $requestarray){
        if (isset($requestarray['skills']) && !empty($requestarray['skills'])) {
            $row->skills()->sync($requestarray['skills']);
        }
        if (isset($requestarray['tags']) && !empty($requestarray['tags'])) {
            $row->tags()->sync($requestarray['tags']);
        }
    }
    protected function uploadImage($request){
        $file = $request->file('image');

        $fileName = time().Str::random('10').'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads') , $fileName);
        return $fileName;
    }




}
