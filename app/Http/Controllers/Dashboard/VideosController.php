<?php
namespace App\Http\Controllers\Dashboard;
use App\Models\Category;
use App\Http\Requests\BackEnd\Videos\Store;
use App\Http\Requests\BackEnd\Videos\Update;
use App\Models\Skill;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use App\Notifications\AddVideo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
class VideosController extends DashboardController
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
    public function store(Store $request)
    {
        $fileName = $this->uploadImage($request);
        // Create the model instance without 'skills' and 'tags'
        $requestArray = $request->all();
        $videoData = [
            'user_id' => auth()->user()->id,
            'image' => $fileName,
       ] + Arr::except($requestArray, ['skills', 'tags']);
        $row = $this->model::create($videoData);
        // Attach skills and tags to the created model
        $this->syncTagsSkills($row, $requestArray);
        // Notify users about the new video
        $users = User::where('id', '!=', auth()->user()->id)->get();
        $userCreate = auth()->user()->name;
        Notification::send($users, new AddVideo($row->id, $userCreate, $row->name));
        return redirect()->route('videos.index');
    }

    public function update($id,Update $request){
        $requestarray = $request->all();
        if($request->hasFile('image')){
            $fileName = $this->uploadImage($request);
            $requestarray = ['image' => $fileName] + $requestarray;
        }
        $row= $this->model->findOrFail($id);
       // dd($row,$this->model);
        $this->syncTagsSkills($row , $requestarray);
        return redirect()->route('videos.index');
    }
    protected function syncTagsSkills($row, $requestArray)
        {
    // Check if 'skills' key is set in $requestArray and is not empty
    if (isset($requestArray['skills']) && !empty($requestArray['skills'])) {
        // Attach skills to the created video using the pivot table
        $row->skills()->attach($requestArray['skills']);
    }
    // Check if 'tags' key is set in $requestArray and is not empty
    if (isset($requestArray['tags']) && !empty($requestArray['tags'])) {
        // Attach tags to the created video using the pivot table
        $row->tags()->attach($requestArray['tags']);
    }
}
    protected function uploadImage($request){
        $file = $request->file('image');

        $fileName = time().Str::random('10').'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads') , $fileName);
        return $fileName;
    }
}
