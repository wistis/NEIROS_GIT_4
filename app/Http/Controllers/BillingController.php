<?php

namespace App\Http\Controllers;

use App\Models\BillingRashodOperation;
use App\Models\Call\CallCost;
use App\Models\MetricaCurrent;
use App\User;
use Auth;
use DB;
use Log;
use Illuminate\Http\Request;

class BillingController extends Controller
{

    public function add_rashod()
    {
        if (auth()->user()->super_admin == 1) {
            $rashod = new BillingRashodOperation;
            $rashod->user_id = request()->get('id');
            $rashod->admin_id = auth()->user()->id;
            $rashod->summ = request()->get('summ');
            $rashod->comment = request()->get('comment');
            $rashod->save();

            $user = User::find(request()->get('id'));

            $user->getcompany->ballans = $user->getcompany->ballans - request()->get('summ');
            $user->getcompany->save();
            $user->save();
            return redirect('/setting/adminclient');

        }


    }
public function get_posetitel_month($company_id){
    $MetricaCurrent = new MetricaCurrent();
    $posetitel = $MetricaCurrent->setTable('metrica_' . $company_id)->where('reports_date', '>', date('Y-m-d', strtotime('-1 month')))->where('bot', 0)
        ->select(
            DB::raw('count(DISTINCT(neiros_visit)) as posetitel')

        )->groupBy('reports_date')->
        orderby('posetitel', 'desc')
        ->first();
    if ($posetitel) {
        $pos = $posetitel->posetitel;
    } else {
        $pos = 0;
    }
    return $pos;
}
public function calls_today($company_id){
 return   CallCost::where('my_company_id',$company_id)->whereBetween('date', [date('Y-m-d 00:00:01'), date('Y-m-d 23:59:59')])->get();
}

    public function billing_all()
    {


        $PayCompanyController = new PayCompanyController();
        $paycompanys = $PayCompanyController->grid();
        $CheckcompanysControllers = new CheckcompanysControllers();

        $checkcompanys = $CheckcompanysControllers->index();

        $phones = $this->phones();
        $recs = $this->recs();


        $user = auth()->user();




        $calls = $this->calls_today($user->my_company_id);
        $min = $calls->sum('duration') / 60;
        $min_sum = $calls->sum('summ');


        $tarif = $user->getMyCompany->getTariff;
        if (!$tarif) {
            $minuta = 1.6;
            $price_number = 300;
            $tarif_price = 0;
        } else {
            $minuta = str_replace(',', '.', $tarif->minuta);
            $price_number = $tarif->phone;
            $tarif_price = $tarif->month / 30;
        }
        $phone_amount = $user->getNumbersActive();
        $price_number_day = round($price_number / 30, 2) * $phone_amount;

        $total_sum = round($tarif_price + $price_number_day + $min_sum, 2);
$pos=$this->get_posetitel_month($user->my_company_id);

        return view('billing.billing_all', compact('paycompanys', 'checkcompanys', 'phones', 'recs', 'balans', 'user', 'pos', 'min', 'min_sum', 'phone_amount', 'price_number_day', 'total_sum'));
    }

    public function recs()
    {

        $user = Auth::user();


        $date_start = date('Y-m-d', strtotime(date('Y', time()) . '-' . date('m') . '-01'));
        $date_end = date('Y-m-t', strtotime(date('Y') . '-' . date('m', time()) . '-' . date('d')));
        $data['tarif'] = DB::table('tarifs')->where('id', $user->tarif)->first();
        $data['month'] = $data['tarif']->phone;
        $number = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
        $summ_day = round($data['tarif']->phone / $number, 2);
        $amountday = $this->get_amount_day(date('Y-m-d'), $date_start);


        if ($user->super_admin == 1) {

            $my_company = 0;
        } else {
            $my_company = $user->my_company_id;


        };
        $tip = 0;
        $minuta = $data['tarif']->minuta;
        if (is_null($minuta)) {
            $minuta = 1.6;
        }
        $data = $this->get_tablica_calltrack($my_company, $date_start, $date_end, $minuta, $tip);
        $data['day'] = $summ_day;
        $data['clients'] = [];
        $data['tarif'] = DB::table('tarifs')->where('id', $user->tarif)->first();
        $data['month'] = $data['tarif']->phone;
        $data['stat_start_date'] = $date_start;
        $data['stat_end_date'] = date('Y-m-d');
        if ($user->super_admin == 1) {

            $data['clients'] = DB::table('users')->get();
        }
        $data['user'] = $user;

        return view('billing.recs', $data);


    }

    public function phones()
    {
        $user = Auth::user();


        $date_start = date('Y-m-d', strtotime(date('Y', time()) . '-' . date('m') . '-01'));
        $date_end = date('Y-m-t', strtotime(date('Y') . '-' . date('m', time()) . '-' . date('d')));
        $data['tarif'] = DB::table('tarifs')->where('id', $user->tarif)->first();
        $data['month'] = $data['tarif']->phone;
        $number = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
        $summ_day = round($data['tarif']->phone / $number, 2);
        $amountday = $this->get_amount_day(date('Y-m-d'), $date_start);


        if ($user->super_admin == 1) {

            $my_company = 0;
        } else {
            $my_company = $user->my_company_id;


        }


        $data = $this->get_tablica($my_company, $date_start, $date_end, $amountday, $summ_day);

        $data['day'] = $summ_day;
        $data['clients'] = [];
        $data['tarif'] = DB::table('tarifs')->where('id', $user->tarif)->first();
        $data['month'] = $data['tarif']->phone;
        $data['stat_start_date'] = $date_start;
        $data['stat_end_date'] = date('Y-m-d');
        if ($user->super_admin == 1) {

            $data['clients'] = DB::table('users')->get();
        }
        $data['user'] = $user;

        return view('billing.phones', $data);
    }


    public function get_tablica_calltrack($my_company, $date_start, $date_end, $minuta, $tip)
    {
        if (is_null($minuta)) {
            $minuta = 1.6;
        }
        try {
            $sec = round(str_replace(',', '.', $minuta) / 60);
        } catch (\Exception $e) {

        }

        if ($my_company > 0) {
            $phone_array = DB::table('bay_phones')->where('my_company_id', $my_company)->pluck('phone');
        } else {
            $phone_array = DB::table('bay_phones')->pluck('phone');

        }
        $data = [];
        $total_summ = 0;
        $i = 0;
        if (($tip == 0) || ($tip == 1)) {

            $phones = DB::connection('asterisk')->table('calls')->wherein('did', $phone_array)->whereBetween('calldate', [$date_start, $date_end])->where('dialstring', 'LIKE', 'SIP/runexis%')->get();

            foreach ($phones as $phone) {


                $data['phones'][$i]['phone'] = $phone->did;
                $data['phones'][$i]['input'] = $phone->src;
                $data['phones'][$i]['duration'] = $phone->duration;
                $data['phones'][$i]['created_at'] = $phone->calldate;
                $data['phones'][$i]['minuta'] = $minuta;
                $data['phones'][$i]['summ'] = round($phone->duration * $sec / 100, 2);
                $data['phones'][$i]['tip'] = 'Колтрекинг';

                $total_summ += $data['phones'][$i]['summ'];

                $i++;
            }
        }
        if (($tip == 0) || ($tip == 2)) {
            if ($my_company > 0) {
                $phone_arrays = DB::table('widgets_phone_routing')->where('my_company_id', $my_company)->where('tip_calltrack', 1)->get();
            } else {
                $phone_arrays = DB::table('widgets_phone_routing')->where('tip_calltrack', 1)->get();

            }
            $new_array = [];
            foreach ($phone_arrays as $phone_array) {
                $new_array[] = 'SIP/runexis/' . $phone_array->number_to;
            }


            $phones = DB::connection('asterisk')->table('callback_calls')->wherein('dialstring', $new_array)->whereBetween('calldate', [$date_start, $date_end])->where('dialstring', 'LIKE', 'SIP/runexis%')->get();


            foreach ($phones as $phone) {


                $data['phones'][$i]['phone'] = str_replace('SIP/runexis/', '', $phone->dialstring);
                $data['phones'][$i]['input'] = $phone->aon;
                $data['phones'][$i]['duration'] = $phone->duration;
                $data['phones'][$i]['created_at'] = $phone->calldate;
                $data['phones'][$i]['minuta'] = $minuta * 2;
                $data['phones'][$i]['summ'] = round($phone->duration * $sec / 100 * 2, 2);
                $data['phones'][$i]['tip'] = 'Колбэк';

                $total_summ += $data['phones'][$i]['summ'];

                $i++;
            }
        }

        $data['total_summ'] = $total_summ;
        return $data;
    }

    public function get_tablica($my_company, $date_start, $date_end, $amountday, $summ_day)
    {

        $data = [];
        $phones = DB::table('bay_phones')->where(function ($query) use ($my_company, $date_start, $date_end) {
            if ($my_company > 0) {
                $query->where('my_company_id', $my_company);
            }

            //  $query->where('created_at','<=',$date_start) ->where('updated_at','<=',$date_end);


        })->get();
        $total_summ = 0;
        foreach ($phones as $phone) {

            $datedel = strtotime($phone->updated_at);
            $strdate = strtotime($date_start);


            $data['phones'][$phone->id]['phone'] = $phone->phone;
            $data['phones'][$phone->id]['my_company_id'] = $phone->my_company_id;
            $data['phones'][$phone->id]['was_deleted'] = $phone->was_deleted;
            $data['phones'][$phone->id]['created_at'] = $phone->created_at;
            $data['phones'][$phone->id]['updated_at'] = $phone->updated_at;
            if ($phone->was_deleted == 0) {
                if (strtotime($phone->created_at) > strtotime($date_start)) {
                    $amountday = $this->get_amount_day($date_end, $phone->created_at);
                } else {
                    $amountday = $this->get_amount_day($date_end, $date_start);
                }
                $data['phones'][$phone->id]['summ_day'] = round($summ_day * $amountday, 2);
                $total_summ += $data['phones'][$phone->id]['summ_day'];
            } else {
                $amount_del = $this->get_amount_day(date('Y-m-d', $datedel), $phone->created_at);

                if ($amount_del <= 0) {
                    $data['phones'][$phone->id]['summ_day'] = 0;
                } else {
                    $data['phones'][$phone->id]['summ_day'] = round($summ_day * $amount_del, 2);
                    $total_summ += $data['phones'][$phone->id]['summ_day'];
                }


            }


        }
        $data['total_summ'] = $total_summ;
        return $data;

    }

    public function get_amount_day($start_day, $end_day)
    {

        $now = strtotime($start_day); // or your date as well
        $your_date = strtotime($end_day);
        $datediff = $now - $your_date;

        return $amountday = round($datediff / (60 * 60 * 24));


    }
}
