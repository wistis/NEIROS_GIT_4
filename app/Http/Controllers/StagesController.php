<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stage;
use Auth;


class StagesController extends Controller
{


    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {

        return   $this->grid();

    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {


        return  $this->form($id) ;

    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
      return  $this->form() ;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {$user=Auth::user();
         $datas['stages']=Stage::orderby('sort','asc')->where('my_company_id',$user->my_company_id)->get();
         return view('setting.stages.list',$datas);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id=null)
    {
        $user=Auth::user();
if(is_null($id)){

    return view('setting.stages.add');

}else{

    $data=Stage::where('my_company_id',$user->my_company_id)->findOrFail($id);
    return view('setting.stages.edit',$data);}



    }

public function store(Request $request){
    $user=Auth::user();

        if($request->stageId==0) {
            $flight = Stage::insert(['name' => trim($request->name),

                'color' => trim($request->color,','),
                'my_company_id'=>$user->my_company_id]);

    }else{
        Stage::where('id',$request->stageId)->where('my_company_id',$user->my_company_id)->update([
            'name'=>$request->name,
            'color' => trim($request->color,','),
        ]);


    }


}
    public function destroy($id){
    $user=Auth::user();
        Stage::where('id',$id)->where('my_company_id',$user->my_company_id)->delete();
    }

    public function updatesort(Request $request){
        $user=Auth::user();
$datas=$request->del;
for($i=0;$i<count($datas);$i++){
    Stage::where('id',$datas[$i])->where('my_company_id',$user->my_company_id)->update(['sort'=>$i]);

}

        return'123';
    }


    public static function create_default_stage($my_company_id){
$stage_default=[
    'В работе'=>'','Выполнены'=>'#87f2c0','Отказ'=>'#ff8f92'
];

         foreach($stage_default as $key=>$val) {
             Stage::insert(['name' =>$key,

                 'color' =>$val,
                 'my_company_id' => $my_company_id]);
         }
    }
}
