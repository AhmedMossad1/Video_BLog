<?php
namespace App\Http\Controllers\Dashboard;
use App\Models\Skill;
use App\Http\Requests\BackEnd\Skills\Store;
class SkillsController extends DashboardController
{
    public function __construct(Skill $model)
    {
        parent::__construct($model);
    }
    public function store(Store $request){
        $this->model::create($request->all());
        return redirect()->route('skills.index');

    }
    public function update($id,Store $request){
        $row= Skill::findOrfail($id);
        $row->update($request->all());
        return redirect()->route('skills.index');
    }
}
