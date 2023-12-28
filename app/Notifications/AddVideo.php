<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AddVideo extends Notification
{
    use Queueable;
    private $video_id;
    private $user_create;
    private $video_name;

    public function __construct($video_id,$user_create,$video_name)
    {
        $this->video_id=$video_id;
        $this->user_create = $user_create;
        $this->video_name=$video_name;
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

        ];
    }
}
