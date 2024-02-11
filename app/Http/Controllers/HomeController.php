<?php
namespace App\Http\Controllers;
use App\Http\Requests\FrontEnd\Comments\Store;
use App\Http\Requests\FrontEnd\Messages\Store as MessagesStore;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Comments;
use App\Models\Message;
use App\Models\Page;
use App\Models\Skill;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\FrontEnd\Users\Store as UsersStore;
use Illuminate\Support\Facades\DB;
use App\Notifications\AddComments;
use Illuminate\Support\Facades\Notification;
class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only([
            'commentUpdate' , 'commentStore'
        ]);
    }
    public function index()
    {
        $videos = Video::published()->orderBy('id' , 'desc');
        if(request()->has('search') && request()->get('search') != ''){
            $videos = $videos->where('name' , 'like' , "%".request()->get('search')."%");
        }
        $videos = $videos->paginate(30);
        return view('home' , compact('videos'));
    }
    public function category($id){
        $cat = Category::findOrFail($id);
        $videos = Video::published()->where('cat_id' , $id)->orderBy('id' , 'desc')->paginate(30);
        return view('front-end.category.index' , compact('videos' , 'cat'));
    }
    public function video($id){
        $video = Video::published()->with('skills' , 'tags' , 'cat' , 'user','comments.user' )->findOrFail($id);
        $getID = DB::table('notifications')->where('data->video_id',$id)->pluck('id');
      //  DB::table('notifications')->where('id',$getID)->update(['read_at'=>now()]);
        return view('front-end.video.index' , compact('video'));
    }
    public function skills($id){
        $skill = Skill::findOrFail($id);
        $videos = Video::published()->whereHas('skills' , function ($query) use ($id){
            $query->where('skill_id' , $id);
        })->orderBy('id' , 'desc')->paginate(30);
        return view('front-end.skill.index' , compact('videos' , 'skill'));
    }
    public function tags($id){
        $tag = Tag::findOrFail($id);
        $videos = Video::published()->published()->whereHas('tags' , function ($query) use ($id){
            $query->where('tag_id' , $id);
        })->orderBy('id' , 'desc')->paginate(30);
        return view('front-end.tag.index' , compact('videos' , 'tag'));
    }
    public function commentUpdate($id , Store $request){
        $comment = Comments::findOrFail($id);
        if(($comment->user_id == auth()->user()->id) || auth()->user()->group == 'admin'){
            $comment->update(['comment' => $request->comment]);
        }
    }
    public function commentStore($id , Store $request){
        $video = Video::published()->findOrFail($id);
        $row = Comments::create([
            'user_id' => auth()->user()->id,
            'video_id' => $video->id,
            'comment' => $request->comment
        ]);
        $users = User::where('id','!=',auth()->user()->id)->get();
        $user_create = auth()->user()->name;
        Notification::send($users,new AddComments($video->id,$user_create,$video->name,$row->id,$request->comment));
        return view('front-end.video.index' , compact('video'));
    }
    public function messageStore(MessagesStore  $request){
        Message ::create($request->all());
        return redirect()->route('frontend.landing');
    }
    public function welcome(){
        $videos = Video::published()->orderBy('id' , 'desc')->paginate(9);
        $videos_count = Video::published()->count();
        $comments_count = Comments::count();
        $tags_count = Tag::count();
        return view('welcome' , compact('videos' , 'tags_count' , 'comments_count' , 'videos_count'));
    }
    public function page($id , $slug = null){
        $page = Page::findOrFail($id);
        return view('front-end.page.index' , compact('page'));
    }
    public function profile($id , $slug = null){
        $user = User::findOrFail($id);
        return view('front-end.profile.index' , compact('user'));
    }
    public function profileUpdate(UsersStore $request){
        $user = User::findOrFail(auth()->user()->id);
        $array = [];
        if($request->email != $user->email){
            $email = User::where('email' , $request->email)->first();
            if($email == null){
                $array['email'] =  $request->email;
            }
        }
        if($request->name != $user->name){
            $array['name'] =  $request->name;
        }
        if($request->password != ''){
            $array['password'] =  Hash::make($request->password);
        }
        if(!empty($array)){
            $user->update($array);
        }

        return redirect()->route('front.profile' , ['id' => $user->id , 'slug' =>slug($user->name)]);
        // return view('front-end.profile.index' , compact('user'));
    }
    // Mark all Notifications as Read
    public function markAsRead(){
        $user = User::find(auth()->user()->id);
        foreach($user->unreadNotifications as $notification){
        $notification->markAsRead();
        }
        return redirect()->back();

    }





}
