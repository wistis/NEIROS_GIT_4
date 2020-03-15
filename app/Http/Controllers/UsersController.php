<?php

namespace App\Http\Controllers;

use App\Models\Servies\GroupRoleUser;
use App\Models\Servies\UsersGroup;
use App\Models\Servies\UsersGroupSelect;
use App\User;
use App\User_roles;
use Illuminate\Http\Request;
use Auth;
use Image;
class UsersController extends Controller
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
        $datas['stages'] = User::with('groups')->with('grouproles')->where('my_company_id', $user->my_company_id)->get();
        $datas['groups'] = UsersGroup::where('my_company_id', $user->my_company_id)->with('users')->get();

        return view('setting.users.list', $datas);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id = null)
    {
        $user = Auth::user();
        if (is_null($id)) {
            $usersgroup = UsersGroup::where('my_company_id', auth()->user()->my_company_id)->get();
            return view('setting.users.add', compact('usersgroup'));

        } else {

            $data['user'] = User::where('my_company_id', $user->my_company_id)->findOrFail($id);
            $data['modulsdelki'] = User_roles::where('user_id', $id)->where('modul', 0)->first();
            $data['modultask'] = User_roles::where('user_id', $id)->where('modul', 1)->first();
            $data['modulcontact'] = User_roles::where('user_id', $id)->where('modul', 2)->first();
            $data['modulcompany'] = User_roles::where('user_id', $id)->where('modul', 3)->first();

            return view('setting.users.edit', $data);
        }


    }

    public function store(Request $request)
    {
        $user = Auth::user();
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
                'my_company_id' => $user->my_company_id,
                'site' => auth()->user()->site,
                'users_group_id' => $request->users_group_id,
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

            if(auth()->user()->super_admin==1){

                User::where('id', $request->taskId)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'users_group_id' => $request->users_group_id,

                    'role' => $request->role,
                    'tarif' => $request->tarif
                ]);

            }else{

                User::where('id', $request->taskId)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'users_group_id' => $request->users_group_id,

                    'role' => $request->role
                ]);
            }


            if (strlen($request->password) > 5) {
                User::where('id', $request->taskId)->update([
                    'password' => bcrypt($request->password)
                ]);
                /* ,*/
            }
            User_roles::where('user_id', $request->taskId)->delete();
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


    }

    public function destroy($id)
    {
        $user = Auth::user();
        User::where('id', $id)->where('my_company_id', $user->my_company_id)->delete();
    }

    public function getajaxuser()
    {

        $user = User::where('id', request()->get('id'))->where('my_company_id', auth()->user()->my_company_id)->with('groups')-> with('grouproles')->first();
        if (!$user) {
            return '';;
        }
        $usergroups = UsersGroup::where('my_company_id', auth()->user()->my_company_id)->get();
        $usergroups_select = UsersGroupSelect::where('user_id',$user->id)->pluck('group_id')->toArray();
        $usergroups_role = GroupRoleUser::where('user_id',$user->id)->pluck('group_id')->toArray();
        return view('setting.users.client_info_modal', compact('user', 'usergroups','usergroups_select','usergroups_role'))->render();


    }

    public function getnewuser()
    {

        $user = null;

        $usergroups = UsersGroup::where('my_company_id', auth()->user()->my_company_id)->get();
        return view('setting.users.client_info_modal', compact('user', 'usergroups'))->render();


    }
public function set_user_group(){





        $users_group_id = request()->get('group');
        UsersGroupSelect::where('group_id', $users_group_id)->delete();
        foreach (request()->get('user') as $key => $val) {

            $ugrup = new UsersGroupSelect();
            $ugrup->user_id = $val;
            $ugrup->group_id = $users_group_id;
            $ugrup->save();

        }



return UsersGroupSelect::where('group_id', $users_group_id)->count();
}
    public function saveajaxuser()
    {



        if (request()->get('id') > 0) {
            $is_new = 0;
            $user = User::where('my_company_id', auth()->user()->my_company_id)->where('id', request()->get('id'))->first();
            if (!$user) {

                $data['status'] = 0;
                $data['message'] = 'Пользователь не найдей';
                return $data;
            }
        } else {

            $user = new User();


            $user->my_company_id = auth()->user()->my_company_id;
            $user->site = auth()->user()->site;
            $is_new = 1;
        }
       $prowemail=User::where('email',request()->get('email'))->where('id','!=',request()->get('id'))->first();
         if($prowemail){

             $data['status']=1;
             $data['message']='E-mail не уникален';
             return $data;
         }
         if(request()->get('phone')!=''){

             $prowemail=User::where('phone',request()->get('phone'))->where('id','!=',request()->get('id'))->first();
             if($prowemail){

                 $data['status']=1;
                 $data['message']='Телефон не уникален';
                 return $data;
             }



         }
        if (request()->get('name') == '') {

            $data['status'] = 1;
            $data['message'] = 'Имя не должно быть пустым';
            return $data;
        }

        $user->name = request()->get('name');
        $user->email =   request()->get('email');
        $user->phone = request()->get('phone');



        if (request()->get('password') != $user->password) {

            $user->password = bcrypt(request()->get('password'));

        }

        $user->save();














        GroupRoleUser::where('user_id', $user->id)->delete();
        if (is_array(request()->get('role'))) {

            $users_group_id = request()->get('role');

            foreach ($users_group_id as $key => $val) {

                $ugrup = new GroupRoleUser();
                $ugrup->user_id = $user->id;
                $ugrup->group_id = $val;
                $ugrup->save();

            }


        } UsersGroupSelect::where('user_id', $user->id)->delete();
        if (is_array(request()->get('users_group_id'))) {

            $users_group_id = request()->get('users_group_id');

            foreach ($users_group_id as $key => $val) {

                $ugrup = new UsersGroupSelect();
                $ugrup->user_id = $user->id;
                $ugrup->group_id = $val;
                $ugrup->save();

            }


        }


        if ($is_new == 1) {


            $data['html'] = view('setting.users.clien_tr_info', compact('user'))->render();

            User_roles::insert([
                'modul' => 0,
                'user_id' => $user->id,
                'create' => 1,
                'read' => 1,
                'edit' => 1,
                'delete' => 1,
            ]);
            User_roles::insert([
                'modul' => 1,
                'user_id' => $user->id,
                'create' => 1,
                'read' => 1,
                'edit' => 1,
                'delete' => 1,
            ]);
            User_roles::insert([
                'modul' => 2,
                'user_id' => $user->id,
                'create' => 1,
                'read' => 1,
                'edit' => 1,
                'delete' => 1,
            ]);
            User_roles::insert([
                'modul' => 3,
                'user_id' => $user->id,
                'create' => 1,
                'read' => 1,
                'edit' => 1,
                'delete' => 1,
            ]);


        }
        $data['status'] = 2;
        $data['is_new'] = $is_new;



if(request()->file('image')) {
    $file = request()->file('image');

    $filename = md5(time()) . '.' . $file->getClientOriginalExtension();


    $user->image = $filename;
    $user->save();


    $file->move(public_path().'/user_upload/user_logo/',   $filename);


    $user->save();


}




        $data['message'] = 'Данные успешно сохранены';
        return $data;
    }
}
