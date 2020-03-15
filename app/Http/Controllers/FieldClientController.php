<?php

namespace App\Http\Controllers;

use App\Field_tip_param;
use Illuminate\Http\Request;
use App\Field;
use App\Field_tip;
use Auth;


class FieldClientController extends Controller
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
    {
        $datas['tipfields']=1;
$user=Auth::user();;
        $datas['stages']=Field_tip::all()->where('tip',1)->where(  'my_company_id',$user->my_company_id);
        $datas['title']='Доп поля контактов';
        return view('setting.field.list',$datas);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id=null)
    {$data['tipfields']=1;
    $user=Auth::user();
        $data['tip_fields']=Field::all();
        if(is_null($id)){
            $data['title']='Доп поля контактов';
            return view('setting.field.add',$data);

        }else{

            $data=Field_tip::where('my_company_id',$user->my_company_id)->findOrFail($id);

            $data['tipfields']=1;
            $data['tip_field']=Field::find($data->field_id);
            $allfields=Field_tip_param::where('field_tip_id',$id)->where('my_company_id',$user->my_company_id)->get();
            $k=[];
            foreach ($allfields as $a){
                $k[]=$a->name;

            }
            $data['allfields']=implode(',',$k);
            $data['title']='Доп поля контактов';
            return view('setting.field.edit',$data);

        }



    }

    public function store(Request $request){
       $user=Auth::user();
        if($request->stageId==0) {

            /*     stageId:stageId,
             name:name,
             name:name,
             vields_values:vields_values,*/

            $flight_id = Field_tip::insertGetId(['name' => trim($request->name),
                'field_id'=>$request->tip_fields,'tip'=>1,'my_company_id',$user->my_company_id
            ]);

            $get_field=Field::find($request->tip_fields);
            if($get_field->is_text==0){
                $array=explode(',',$request->vields_values);
                for($i=0;$i<count($array);$i++){

                    Field_tip_param::insert([
                        'name'=>trim($array[$i]),
                        'field_id'=>$get_field->id ,
                        'field_tip_id'=>$flight_id ,
                        'my_company_id',$user->my_company_id


                    ]);


                }
            }

            return '0';
        }else{
            Field_tip::where('id',$request->stageId)->update(['name'=>$request->name]);

            $get_field=Field::find($request->tip_fields);
            if($get_field->is_text==0){

                Field_tip_param::where('field_tip_id',$request->stageId)->where('my_company_id',$user->my_company_id)->delete();
                $array=explode(',',$request->vields_values);
                for($i=0;$i<count($array);$i++){

                    Field_tip_param::insert([
                        'name'=>trim($array[$i]),
                        'field_id'=>$get_field->id ,
                        'field_tip_id'=> $request->stageId,
                        'my_company_id',$user->my_company_id


                    ]);


                }
            }
        }


    }

    public function show(Request $request){

        if(in_array($request->stageId,[1,2,6,7,8,9])){
            return 0;
        }else{

            return 1;

        }




    }

    public function destroy($id){
        $user=Auth::user();;
        Field_tip::where('id',$id)->where('my_company_id',$user->my_company_id)->delete();
    }




}
