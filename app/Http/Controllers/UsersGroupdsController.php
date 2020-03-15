<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Servies\UsersGroup;
use Illuminate\Http\Request;
use Auth;

class UsersGroupdsController extends Controller
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
        $user=Auth::user();
        $datas['stages'] = UsersGroup::where('my_company_id', $user->my_company_id)->get();
        return view('setting.users_groups.list', $datas);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id = null)
    {$user=Auth::user();
        if (is_null($id)) {

            return view('setting.users_groups.add');

        } else {

            $data['user'] = UsersGroup::where('my_company_id', $user->my_company_id)->findOrFail($id);


            return view('setting.users_groups.edit', $data);
        }


    }
public function update($id,Request $request){
 $group=UsersGroup::where('id', $id)->where('my_company_id', auth()->user()->my_company_id)->first();
 if($group)
 {
     $group->name=$request->name;
     $group->save();

 }

    return redirect('/setting/usersgroup');
    }
    public function store(Request $request)
    {
$group=new UsersGroup();
        $group->name=$request->name;
        $group->my_company_id=auth()->user()->my_company_id;
        $group->save();
        $stages = User::all()->where('my_company_id', auth()->user()->my_company_id);
return view('setting.users.group_tr',compact('group','stages'))->render();
    }

    public function destroy($id)
    {
        $user=Auth::user();
        UsersGroup::where('id', $id)->where('my_company_id', $user->my_company_id)->delete();
    }
}
