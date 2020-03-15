<?php

namespace App\Http\Controllers;
use DB;
use App\User;
use App\User_roles;
use Illuminate\Http\Request;
use Auth;

class AdminclientController extends Controller
{

public function loginas($id){
    $user=Auth::user();
if($user->super_admin==1){

    \Cookie::queue('admin',$user->id , 3600*24);

    Auth::loginUsingId($id);
return redirect('/');


}


}
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
       
        $user=Auth::user();
        $datas['stages'] = User::where('role',0)->where('is_first_reg',1)->get();
        return view('setting.users.listadmin', $datas);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id = null)
    {$user=Auth::user();
        if (is_null($id)) {

            return view('setting.users.addadminclient');

        } else {

            $data['user'] = User::findOrFail($id);
            $data['modulsdelki'] = User_roles::where('user_id',$id)->where('modul',0)->first();
            $data['modultask'] = User_roles::where('user_id',$id)->where('modul',1)->first();
            $data['modulcontact'] = User_roles::where('user_id',$id)->where('modul',2)->first();
            $data['modulcompany'] = User_roles::where('user_id',$id)->where('modul',3)->first();

            return view('setting.users.edit', $data);
        }


    }

    public function store(Request $request)
    {
        $companyId=DB::table('users_company')->insertgetId(['name'=>$request->company]);
        $user=Auth::user();
        /*    taskId: taskId,
            name: name,
            email: email,
            password: password,
            role: role,
            _token: $('[name=_token]').val(),
            dataroles:dataroles*/
        if ($request->taskId == 0) {

            $user_id = User::insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'my_company_id'=> $companyId,
                'is_first_reg'=> 1,
                'apikey'=>md5(time().rand(1,10000))
            ]);

            $dataroles = $request->dataroles;

            User_roles::insert([
                'modul' => 0,
                'user_id' => $user_id,
                'create' => $dataroles['modulsdelki']['create'],
                'read' => $dataroles['modulsdelki']['read'],
                'edit' => $dataroles['modulsdelki']['edit'],
                'delete' => $dataroles['modulsdelki']['delete'],
            ]);
            User_roles::insert([
                'modul' => 1,
                'user_id' => $user_id,
                'create' => $dataroles['modultask']['create'],
                'read' => $dataroles['modultask']['read'],
                'edit' => $dataroles['modultask']['edit'],
                'delete' => $dataroles['modultask']['delete'],
            ]);
            User_roles::insert([
                'modul' => 2,
                'user_id' => $user_id,
                'create' => $dataroles['modulcontact']['create'],
                'read' => $dataroles['modulcontact']['read'],
                'edit' => $dataroles['modulcontact']['edit'],
                'delete' => $dataroles['modulcontact']['delete'],
            ]);
            User_roles::insert([
                'modul' => 3,
                'user_id' => $user_id,
                'create' => $dataroles['modulcompany']['create'],
                'read' => $dataroles['modulcompany']['read'],
                'edit' => $dataroles['modulcompany']['edit'],
                'delete' => $dataroles['modulcompany']['delete'],
            ]);

        } else {
            User::where('id',$request->taskId)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,

                'role' => $request->role,
                'apikey' => $request->apikey
            ]);
            if(strlen($request->password)>5){
                User::where('id',$request->taskId)->update([
                    'password' => bcrypt($request->password)
                ]);
                /* ,*/
            }

            User_roles::where('user_id',$request->taskId)->delete();
            $dataroles = $request->dataroles;

            User_roles::insert([
                'modul' => 0,
                'user_id' => $request->taskId,
                'create' => $dataroles['modulsdelki']['create'],
                'read' => $dataroles['modulsdelki']['read'],
                'edit' => $dataroles['modulsdelki']['edit'],
                'delete' => $dataroles['modulsdelki']['delete'],
            ]);
            User_roles::insert([
                'modul' => 1,
                'user_id' => $request->taskId,
                'create' => $dataroles['modultask']['create'],
                'read' => $dataroles['modultask']['read'],
                'edit' => $dataroles['modultask']['edit'],
                'delete' => $dataroles['modultask']['delete'],
            ]);
            User_roles::insert([
                'modul' => 2,
                'user_id' => $request->taskId,
                'create' => $dataroles['modulcontact']['create'],
                'read' => $dataroles['modulcontact']['read'],
                'edit' => $dataroles['modulcontact']['edit'],
                'delete' => $dataroles['modulcontact']['delete'],
            ]);
            User_roles::insert([
                'modul' => 3,
                'user_id' => $request->taskId,
                'create' => $dataroles['modulcompany']['create'],
                'read' => $dataroles['modulcompany']['read'],
                'edit' => $dataroles['modulcompany']['edit'],
                'delete' => $dataroles['modulcompany']['delete'],
            ]);


        }

 $chema=new SchemaController();
        $chema->index();

        StagesController::create_default_stage($companyId);
    }
    public function show(){

    }
public function set_active($id){
$u= User::findOrFail($id);
if($u->is_active==0){
    $a=1;
}
    if($u->is_active==1){
        $a=0;
    }
    DB::table('users')->where('id',$id)->update(['is_active'=>$a]);
        return redirect('/setting/adminclient');
}
    public function destroy($id)
    {
        $user=Auth::user();

        

        User::where('id', $id) ->delete();
    }
}
