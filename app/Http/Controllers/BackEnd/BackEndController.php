<?php
namespace App\Http\Controllers\BackEnd;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BackEndController extends Controller
{
    protected $model;
    protected $moduleName;
    protected $pageTitle;
    protected $pageDes;
    public function __construct(Model $model){
        $this->model=$model;
    }
    public function index(){
        $rows=$this->model;
        $with = $this->with();
        if(!empty($with)){
            $rows=$rows->with($with);
        }
        if(request()->has('search') && request()->get('search') != ''){
            $rows = $rows->where('name' , 'like' , "%".request()->get('search')."%");
        }
        $rows = $rows->paginate(10);
        $moduleName = $this->pluralModelName();
        $pageDes = "Here you can add / edit / delete " .$moduleName;
        $pageTitle = "Control ".$moduleName;
        $sModuleName = $this->getModelName();
        $routeName = $this->getClassNameFromModel();
        return view('back-end.'.$this->getClassNameFromModel().'.index',compact(
            'rows',
            'moduleName',
            'pageDes',
            'pageTitle',
            'sModuleName',
            'routeName'
        ));
    }
    public function create(){
        $moduleName = $this->getModelName();
        $pageTitle = "Add " . $moduleName;
        $pageDes = "Here you can Add " .$moduleName;
        $folderName= $this->getClassNameFromModel();
        $routeName = $folderName;
        $append=$this->append();
        return view('back-end.'.$folderName.'.create',compact(
            'routeName',
            'pageTitle',
            'pageDes',
            'moduleName',
            'folderName'))->with($append);
    }
    public function edit($id){
        $row=$this->model->findOrFail($id);
        $moduleName = $this->getModelName();
        $pageTitle = "Edit " . $moduleName;
        $pageDes = "Here you can edit " .$moduleName;
        $folderName = $this->getClassNameFromModel();
        $routeName = $folderName;
        $append=$this->append();
        return  view('back-end.' . $folderName . '.edit', compact(
            'row',
            'pageTitle',
            'moduleName',
            'pageDes',
            'folderName',
            'routeName'))->with($append);

    }
    public function destroy($id){
        $this->model->findOrfail($id)->delete();
        return redirect()->route($this->getClassNameFromModel().'.index');
    }
    protected function with(){
        return[];
    }

    protected function getClassNameFromModel(){
        return strtolower($this->pluralModelName());
    }
    protected function pluralModelName(){
        return Str::plural($this->getModelName());
    }
    protected function getModelName(){
        return class_basename($this->model);
    }
    protected function append(){
        return[];
    }
}
