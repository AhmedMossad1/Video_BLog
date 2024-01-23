<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AddComments extends Notification
{
    use Queueable;
    private $video_id;
    private $user_create;
    private $video_name;
    private $comment_id;
    private $comment;

    public function __construct($video_id,$user_create,$video_name,$comment_id,$comment)
    {
        $this->video_id=$video_id;
        $this->user_create = $user_create;
       $this->video_name=$video_name;
        $this->comment_id=$comment_id;
        $this->comment=$comment;
    }


    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'video_id'=>$this->video_id,
            'user_create'=>$this->user_create,
            'video_name'=>$this->video_name,
            'comment_id'=>$this->comment_id,
            'comment'=>$this->comment,


        ];
    }
}
