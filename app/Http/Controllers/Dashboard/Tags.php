<?php
namespace App\Http\Controllers\Dashboard;
use App\Models\Tag;
use App\Http\Requests\BackEnd\Tags\Store;
class Tags extends DashboardController
{
    public function __construct(Tag $model)
    {
        parent::__construct($model);
    }
    public function store(Store $request){
        Tag::create($request->all());
        return redirect()->route('tags.index');

    }
    public function update($id,Store $request){
        $row = Tag::findOrFail($id);
        $row ->update($request->all());
        return redirect()->route('tags.index');

    }





}
