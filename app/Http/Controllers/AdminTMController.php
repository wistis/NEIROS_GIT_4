<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Admin_template_messages;
use Auth;
use Illuminate\Http\Request;
use Log;
use Mail;
use App\Admin_messages;

class AdminTMController extends Controller
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
        $datas['stages'] = Admin_template_messages::get();
        return view('setting.admintm.list', $datas);
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

            return view('setting.admintm.add');

        } else {

            $data = Admin_template_messages::findOrFail($id);
            return view('setting.admintm.edit', $data);
        }


    }

    public function store(Request $request)
    {
        $user = Auth::user();

        //   dd($request);
        if ($request->projectId == 0) {
            $flight = Admin_template_messages::insert(['name' => trim($request->name), 'text' => $request->{'editor-full'}, 'tip' => $request->tip, 'period' => $request->period, 'time' => $request->time]);

        } else {


            Admin_template_messages::where('id', $request->projectId)->update(['name' => trim($request->name), 'text' => $request->{'editor-full'}, 'period' => $request->period, 'time' => $request->time]);;


        }
        return redirect('/setting/admintm');

    }

    public function destroy($id)
    {
        $user = Auth::user();
        Admin_template_messages::where('id', $id)
            ->delete();
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

    public function send_mail($user, $tip, $Atm = null)
    {
        ;
        Log::useFiles(base_path() . '/storage/logs/AdminTMController.log', 'info');
        if ($tip == 0) {

            $mess = Admin_template_messages::where('tip', $tip)->first();
            if (!$mess) {
                return '';
            }

            //  $mail['mail'] = explode(',', $user->email);
            $mail['mail'] = $user->email;
            $mail['subject'] = $mess->name;
            $data['text'] = $mess->text;
            $this->sendmail($data,$mail,$user);
        }
        Log::useFiles(base_path() . '/storage/logs/AdminTMController.log', 'info');
        if ($tip == 1) {

            $mess = $Atm;
            $provmmess = DB::table('admin_messages_cron_today')->where('user_id', $user->id)->where('tip_id', 1)->where('created_at',date('Y-m-d'))->first();
            if ($provmmess) {
                return '';
            }

            if (!$mess) {
                return '';
            }
$array_period=explode(',',$mess->period);
 if(count($array_period)==0){
     return '';
 }
$times_cr=date('Y-m-d',strtotime($user->created_at));
 $date_end=date('Y-m-d',strtotime($times_cr)+(3600*24*14));

for($i=0;$i<count($array_period);$i++){

 $date_tek_plus=date('Y-m-d',(time()+(3600*24*$array_period[$i])));

 if($date_tek_plus==$date_end){

     $mail['mail'] = $user->email;
     $mail['subject'] = $mess->name;
     $array_period[$i];  $text=str_replace('|period|',$array_period[$i].' '.$this->num2word($array_period[$i], array('день', 'дня','дней' )) , $mess->text);;
     $text=str_replace('|date|', date('d.m.Y',strtotime($date_end)), $text);;
     $text=str_replace('|user|', $user->name, $text);;
      $data['text'] = $text;
     $this->sendmail($data,$mail,$user);
     DB::table('admin_messages_cron_today')->insert([
         'user_id'=> $user->id,
         'tip_id'=> 1,
         'created_at'=> date('Y-m-d'),


     ]);



     $id = Admin_messages::insertGetId(
         [
             'tema' => $mess->name,
             'message' => $text,
             'created_at' =>  date('Y-m-d H:i:s'),
             'updated_at' =>  date('Y-m-d H:i:s'),

         ]);
     $datatoinsert[0]['mess_id'] = $id;
     $datatoinsert[0]['user_id'] = $user->id;
     $datatoinsert[0]['status'] = 0;
     $datatoinsert[0]['created_at'] = date('Y-m-d H:i:s');
     $datatoinsert[0]['updated_at'] = date('Y-m-d H:i:s');
     DB::table('admin_messages_read')->insert($datatoinsert);
     //DB::table('')-//
     return '';
 }



}




            //  $mail['mail'] = explode(',', $user->email);

        }



        return '';


    }

    public function sendmail($data,$mail,$user){
        try {$data['user']=$user;
            Mail::send(['html' => 'email'], $data, function ($message) use ($mail) {


                $message->to($mail['mail'], '');

                $message->subject($mail['subject']);
            });
        } catch (\Exception $e) {
            Log::info($user->id);
            Log::info($e);
            return $e;
        }
    }



    function num2word($num, $words)
    {
        $num = $num % 100;
        if ($num > 19) {
            $num = $num % 10;
        }
        switch ($num) {
            case 1: {
                return($words[0]);
            }
            case 2: case 3: case 4: {
            return($words[1]);
        }
            default: {
                return($words[2]);
            }
        }
    }

}
