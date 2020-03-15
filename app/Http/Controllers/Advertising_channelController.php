<?php

namespace App\Http\Controllers;

use App\Models\Advertising_channel;
use App\Models\WidgetCanal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;


class Advertising_channelController extends Controller
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


        $datas['stages']=WidgetCanal::where('my_company_id',$user->my_company_id)->where('site_id',$user->site)->get();
        ;$datas['title']='Рекламные каналы';
        $data['renders']=view('setting.advertisingchannel.list',$datas)->render();

        return $data;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id=null)
    {$user=Auth::user();


        if(is_null($id)){
            ;$data['title']='Рекламные каналы';
            return view('setting.advertisingchannel.add',$data);

        }else{

            $data=Advertising_channel::where('my_company_id',$user->my_company_id)->findOrFail($id);


            ;$data['title']='Рекламные каналы';
            return view('setting.advertisingchannel.edit',$data);

        }



    }

    public function delete1(){
        WidgetCanal::where('id',request()->get('id'))->where('my_company_id',auth()->user()->my_company_id)->delete();
    }
public function safes(){
    $user=Auth::user();
    $widg=new WidgetCanal();
       $widg->name=request()->get('name');





       $widg->site_id=$user->site;
       $widg->my_company_id=$user->my_company_id;
       $widg->save();
$widg->code=Str::slug($widg->name,'_');
    $count=WidgetCanal::where('code',$widg->code)
        ->where('my_company_id',auth()->user()->my_company_id)
        ->where('site_id',auth()->user()->site)->count();
    if($count>0){

        $count=$count+1;
        $widg->code=Str::slug($widg->name.$count,'_');
    }



    $widg->save();
       return '<tr   id="del{{$client->id}}">
                    
                    <td>'.$widg->name.'</td>
                    <td>neiros='.$widg->code.'</td>



                      

                       <td><a href="#" data-id="'.$widg->id.'" data-id="'.$widg->id.'"  class="delet_chenel" ><i class="glyphicon  glyphicon-trash" style="color: red;position: relative"></i></a>
                       </td>
                </tr>';

}
    public function store(Request $request){

        $user=Auth::user();
        if($request->id==0) {


            Advertising_channel::insert([
               'name'=>$request->name,
               'utm'=>$request->utm,
               'site_id'=>$user->site,
               'my_company_id'=>$user->my_company_id,


            ]);

            return redirect('/setting/advertisingchannel');
        }else{
            Advertising_channel::where('id',$request->id)->update([
                'name'=>$request->name,
                'utm'=>$request->utm,



            ]);
            return redirect('/setting/advertisingchannel');
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
