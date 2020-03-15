<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\User;
class EmailController extends Controller
{



    public function get_all()
    {


        $user = Auth::user();



        $data['user'] = $user;
        $data['managers'] = User::all()->where('my_company_id', $user->my_company_id);


        $data['user'] = $user;

            $start_date = date('2017-01-01 00.00.00');;
            $end_date = date('2050-01-01 23:59:59');;
            if (strlen($user->start_date) < 2) {
                $start_date = date('2017-01-01 00.00.00');
            } else {
                $start_date = date('Y-m-d 00.00.01', strtotime($user->start_date));

            }
            if (strlen($user->end_date) < 2) {
                $end_date = date('2050-01-01 23:59:59');
            } else {
                $end_date = date('Y-m-d 23:59:59', strtotime($user->end_date));
            }


            $data['projects'] = DB::table('widgets_email_input')->orderby('id', 'desc')

                ->where('my_company_id', $user->my_company_id)


                ->paginate(20);


            $gettsites = DB::table('sites')->where('my_company_id', $user->my_company_id)->get();



                    $data['projects'] = DB::table('widgets_email_input')->where('site_id',$user->site)->orderby('id', 'desc')

                        ->where('my_company_id', $user->my_company_id)


                        ->paginate(20);


            $data['start_date'] = $user->start_date;
            $data['end_date'] = $user->end_date;
        $datastcanal=DB::table('widgets_email_static')->where('my_company_id', $user->my_company_id)->get();
        $data['canalstat'][0]='Динамический';


        foreach ($datastcanal as $datc){

            $data['canalstat'][$datc->id]=$datc->canal;

        }


            return view('emails.list_table', $data)->render();

    }
}
