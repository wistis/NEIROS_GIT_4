<?php

namespace App\Http\Controllers;
use App\PayCompany;
use App\Checkcompanys;
use DB;
use Illuminate\Http\Request;
use  Auth;
class CheckcompanysControllers extends Controller
{


    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {

        return $this->grid();

    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {


        return $this->form($id);

    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return $this->form();
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()

    {
        $user = Auth::user();



        $datas['admin']=0;
if($user->super_admin==1){$datas['admin']=1;
    $firms=DB::table('pay_company')->select('short_name','id')->get();
    $datas['companys'] = Checkcompanys::get();
}else{
    $firms=DB::table('pay_company')->where('my_company_id',$user->my_company_id)->select('short_name','id')->get();
    $datas['companys'] = Checkcompanys::where('my_company_id', $user->my_company_id)->get();
}


        $datas['firms']=$firms->keyby('id') ;

        return view('billing.check.listcompany', $datas);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id = null )
    {
        $user = Auth::user();

$data['comps']='';
if(isset($_GET['company_id'])){
    $data['comps']=$_GET['company_id'];
}



            $data['company']=PayCompany::where('my_company_id',$user->my_company_id)->get();

            return view('billing.check.add',$data);



    }


    public function store(Request $request)
    {
        $user = Auth::user();


            $data=$request->all();
            unset($data['_token']);
            $data['my_company_id']=$user->my_company_id;
            $data['created_at']=date('Y-m-d H:i:s');
            $data['status']=0;



            Checkcompanys::insert($data);
            return redirect('/setting/checkcompanys');




    }

    public function getschet($id){
$user=Auth::user();

$data['zakaz']=Checkcompanys::where('my_company_id',$user->my_company_id)->where('id',$id)->first();
        $data['company']=PayCompany::where('id',$data['zakaz']->company_id)->first();
        return view('billing.schet',$data);
    }










}
