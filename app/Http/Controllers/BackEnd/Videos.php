<?php
namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Http\Requests\BackEnd\Pages\Store;
use App\Models\Video;

class Videos extends BackEndController
{
    public function __construct(Video $model)
    {
        parent::__construct($model);
    }
    protected function with(){
        return['cat','user'];
    }
    protected function append(){
        return  [
            'categories' => Category::get(),
        ];
    }


    public function store(Store $request){
        Video::create($request->all()+['user_id'=>auth()->user()->id]);
        return redirect()->route('videos.index');
}
    public function update($id,Store $request){
        $row =$this->model::findOrfail($id);
        $row->update($request->all());
        return redirect()->route('videos.index');
}


}
