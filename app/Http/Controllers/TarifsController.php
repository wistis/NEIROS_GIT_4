<?php

namespace App\Http\Controllers;

use App\Models\Tarifs;
use Illuminate\Http\Request;

use Auth;


class TarifsController extends Controller
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
        $user=Auth::user();


        $datas['stages']=Tarifs::all();
        ;$datas['title']='Тарифы';
        return view('setting.tarifs.list',$datas);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id=null)
    {$user=Auth::user();


        if(is_null($id)){
            ;$data['title']='Тарифы';
            return view('setting.tarifs.add',$data);

        }else{

            $data=Tarifs::findOrFail($id);


            ;$data['title']='Тарифы';
            return view('setting.tarifs.edit',$data);

        }



    }

    public function store(Request $request){

        $user=Auth::user();
        if($request->id==0) {
/* {{--`id`, `name`, `month`, `year`, `moduls`, `phone`, `minuta`, `created_at`, `updated_at`--}}*/

            Tarifs::insert([
                'name'=>$request->name,
                'month'=>$request->month,
                'year'=>$request->year,
                'phone'=>$request->phone,
                'minuta'=>$request->minuta,
                'moduls'=>'',



            ]);

            return redirect('/setting/tarifs');
        }else{
            Tarifs::where('id',$request->id)->update([
                'name'=>$request->name,
                'month'=>$request->month,
                'year'=>$request->year,
                'phone'=>$request->phone,
                'minuta'=>$request->minuta,
                'moduls'=>'',


            ]);
            return redirect('/setting/tarifs');
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
        $user=Auth::user();
        Field_tip::where('id',$id)->where('my_company_id',$user->my_company_id)->delete();
    }



}
