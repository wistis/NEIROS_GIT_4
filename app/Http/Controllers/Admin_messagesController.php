<?php

namespace App\Http\Controllers;

use App\Admin_messages;
use Auth;
use DB;
use Illuminate\Http\Request;

class Admin_messagesController extends Controller
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

        if ($user->super_admin == 1) {
            $datas['mess'] = Admin_messages::orderby('created_at','desc')->get();


            return view('setting.amessages.list', $datas);
        } else {
            $datas['mess']=DB::table('admin_messages_read')->
                join('admin_messages','admin_messages.id','=','admin_messages_read.mess_id')->
                where('admin_messages_read.user_id',$user->id)->
                select('admin_messages_read.*','admin_messages.tema as tema')->orderby('admin_messages_read.created_at','desc')->paginate(20);



            return view('setting.amessages.user_list', $datas);
        }
    }
public function get_status_admin($id){

       $amout_all=DB:: table('admin_messages_read')->where('mess_id',$id)->count();
       $amout_all_read=DB:: table('admin_messages_read')->where('mess_id',$id)->where('status',1)->count();

        return 'Прочитано '.$amout_all_read.' из '.$amout_all;
}
    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id = null)
    {
        $user = Auth::user();

        if(is_null($id)){
        if ($user->super_admin == 1) {

            $data['users'] = DB::table('users')->get();
            return view('setting.amessages.add', $data);

        }
        }else{
            DB::table('admin_messages_read')->where('user_id',$user->id)->where('mess_id',$id)->update(['status'=>1]);

            $data['mess'] = Admin_messages::where('id',$id)->first();
            return view('setting.amessages.edit', $data);

        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->super_admin == 1) {

            /*  "_token" => "k2a8fTLLzNPRXFeEpo0gvQHSiTVbKBS78Kn2VkYW"
   "projectId" => "0"
   "tema" => "йуц"
   "message" => "йцуйцу"
   "users" => array:3 [▼
     0 => "0"
     1 => "12"
     2 => "22"
   ]*/

            $id = Admin_messages::insertGetId(
                [
                    'tema' => $request->tema,
                    'message' => $request->message,
                    'created_at' =>  date('Y-m-d H:i:s'),
                    'updated_at' =>  date('Y-m-d H:i:s'),

                ]);

            if (in_array(0, $request->users)) {
                $users = DB::table('users')->get();
                $i = 0;
                $datatoinsert = [];
                foreach ($users as $us) {
                    $datatoinsert[$i]['mess_id'] = $id;
                    $datatoinsert[$i]['user_id'] = $us->id;
                    $datatoinsert[$i]['status'] = 0;
                    $datatoinsert[$i]['created_at'] = date('Y-m-d H:i:s');
                    $datatoinsert[$i]['updated_at'] = date('Y-m-d H:i:s');
$i++;

                }


            } else {
                for ($is = 0; $is < count($request->users); $is++) {
                    $datatoinsert[$is]['mess_id'] = $id;
                    $datatoinsert[$is]['user_id'] = $request->users[$is];
                    $datatoinsert[$is]['status'] = 0;
                    $datatoinsert[$is]['created_at'] = date('Y-m-d H:i:s');
                    $datatoinsert[$is]['updated_at'] = date('Y-m-d H:i:s');


                }


            }
DB::table('admin_messages_read')->insert($datatoinsert);

            /*``(`id`, `mess_id`, `user_id`, `status`, `created_at`, `updated_at`)*/
return redirect('/setting/messages');

        }


    }

    public function destroy($id)
    {
        $user = Auth::user();
        Stage::where('id', $id)->where('my_company_id', $user->my_company_id)->delete();
    }

    public function updatesort(Request $request)
    {
        $user = Auth::user();
        $datas = $request->del;
        for ($i = 0; $i < count($datas); $i++) {
            Stage::where('id', $datas[$i])->where('my_company_id', $user->my_company_id)->update(['sort' => $i]);

        }

        return '123';
    }
}
