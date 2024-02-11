<?php
namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class VideoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'description'=>$this->des,
            'meta_descritption' =>$this->meta_des,
            'user_id' =>$this->user_id,
            'name'=>$this->name,
            'category'=>$this->cat->name,
            'user_name'=>$this->User->name,
        ];
    }
}
