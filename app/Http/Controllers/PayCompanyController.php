<?php

namespace App\Http\Controllers;
use App\PayCompany;
use DB;
use Illuminate\Http\Request;
use  Auth;
class PayCompanyController extends Controller
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
    public function grid()

    {
        $user = Auth::user();



            $datas['companys'] = PayCompany::where('my_company_id', $user->my_company_id)->get();


        return view('billing.listcompany', $datas);
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
            return view('billing.add');
        } else {

$data=PayCompany::where('my_company_id',$user->my_company_id)->where('id',$id)->first();
            return view('billing.edit', $data);
        }


    }


    public function store(Request $request)
    {
        $user = Auth::user();

        if ($request->id == 0) {
$data=$request->all();
unset($data['_token']);
$data['my_company_id']=$user->my_company_id;

try{
    $r=file_get_contents('https://bik-info.ru/api.html?type=json&bik='.$data['bik']);
    $data['bank_info']=$r;
}catch (\Exception $e){

}

PayCompany::insert($data);
            return redirect('/setting/paycompanys');

        } else {
            $data=$request->all();
            $data=$request->all();
            unset($data['_token']);
            $data['my_company_id']=$user->my_company_id;
            try{
                $r=file_get_contents('https://bik-info.ru/api.html?type=json&bik='.$data['bik']);
                $data['bank_info']=$r;
            }catch (\Exception $e){

            }
            unset($data['_token']);
            $data['my_company_id']=$user->my_company_id;
 PayCompany::where('id',$data['id'])->update($data);
            return redirect('/setting/paycompanys');
        }


    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if ($request->stageId == 0) {
            $flight = Company::insertGetId(['name' => trim($request->name), 'my_company_id' => $user->my_company_id]);
            $datafield = $request->datafield;
            $clientAndCompany['client_id'] = $flight;
            $projectId = 0;

            ProjectController:: add_datafield($datafield, $clientAndCompany, $projectId);

            /*datacontact*/
            $datatask = $request->datacontact;
            for ($i = 0; $i < count($datatask); $i++) {


                if ($datatask[$i]['active'] == 1) {


                    if ($datatask[$i]['id'] == 0) {
                        $project_tag = Client::firstOrNew([
                            'fio' => $datatask[$i]['fio'],
                            'email' => $datatask[$i]['phone'],
                            'phone' => $datatask[$i]['email'],
                            'company_id' => $flight,
                            'my_company_id' => $user->my_company_id]);
                        $project_tag->save();
                    }


                }


            }

            /*datacontact*/


        } else {

            Company::where('id', $request->stageId)->update(['name' => $request->name]);
            $datafield = $request->datafield;
            $clientAndCompany['client_id'] = $request->stageId;
            $projectId = 0;
            ProjectController:: add_datafield($datafield, $clientAndCompany, $projectId);

        }
        /*      Company::where('id',$request->stageId)->update(['name'=>$request->name]);
              $datafield=$request->datafield;
              $clientAndCompany['client_id']=$request->stageId;
              $projectId=0;

              ProjectController:: add_datafield($datafield,$clientAndCompany,$projectId);*/
    }

    public function set_status(Request $request)
    {
        $user = Auth::user();
        $datas = Widgets::where('my_company_id', $user->my_company_id)->where('id', $request->element)->first();
        if ($datas) {
            if ($datas->status == 0) {
                $status = 1;
            }
            if ($datas->status == 1) {
                $status = 0;
            }
            Widgets::where('my_company_id', $user->my_company_id)->where('id', $request->element)->update([
                'status' => $status
            ]);
        }
        return '';
    }

    public function safe_widget(Request $request)
    {


        $user = Auth::user();
        $widget = Widgets::where('my_company_id', $user->my_company_id)->where('id', $request->widget_id)->first();
        if (!$widget) {
            return '0';
        }
        if ($widget->tip == 0) {
            return $this->update_tip_0($widget, $user, $request);
        }
        if ($widget->tip == 1) {

            return $this->update_tip_1($widget, $user, $request);
        }
        if ($widget->tip == 4) {

            return $this->update_tip_4($widget, $user, $request);
        }
        if ($widget->tip == 5) {

            return $this->update_tip_5($widget, $user, $request);
        }
        if ($widget->tip == 6) {

            return $this->update_tip_6($widget, $user, $request);
        }
        if ($widget->tip == 7) {

            return $this->update_tip_7($widget, $user, $request);
        }


        if ($widget->tip == 8) {

            return $this->update_tip_8($widget, $user, $request);
        }
        if ($widget->tip == 9) {

            return $this->update_tip_9($widget, $user, $request);
        }
        if ($widget->tip == 10) {

            return $this->update_tip_10($widget, $user, $request);
        }
        if ($widget->tip == 12) {

            return $this->update_tip_12($widget, $user, $request);
        }
        if ($widget->tip == 11) {

            return $this->update_tip_11($widget, $user, $request);
        }
        if ($widget->tip == 14) {

            return $this->update_tip_14($widget, $user, $request);
        }
    }
    public function update_tip_14($widget, $user, $request)
    {
        $widget_promokod = DB::table('widgets_catcher_bots')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);

        DB::table('widgets_catcher_bots')->where('id', $widget_promokod->id)->update(
            [
                'metrika_counter' => $request->radiocounter,
                'metrika_token' => $request->metrika_token,
                'amount_url' => $request->amount_url,
                'class_ul' => $request->class_ul,
                'id_replace' => $request->id_replace,


            ]);


        return 1;

    }
    public function update_tip_12($widget, $user, $request)
    {
        $widget_promokod = DB::table('widgets_chat')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_callback_id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);

        DB::table('widgets_chat')->where('id', $widget_promokod->id)->update(
            [
                'email' => $request->email,
                'phone' => $request->phone,
                'logo' => $request->logo,
                'first_message' => $request->first_message,
                'operator_name' => $request->operator_name,
                'timer' => $request->timer,
                'create_project' => $request->create_project,
                'job'=>$request->job

            ]);


        return 1;

    }

    public function update_tip_11($widget, $user, $request)
    {
        $widget_promokod = DB::table('widget_direct')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);
        DB::table('metrika_direct_company')->where('widget_direct_id', $widget_promokod->id)->update(['status' => 0]);


        for ($i = 0; $i < count($request->counter); $i++) {
            DB::table('metrika_direct_company')->where('widget_direct_id', $widget_promokod->id)->where('id', $request->counter[$i])->update(['status' => 1]);

        }


        return 1;

    }

    public function update_tip_10($widget, $user, $request)
    {
        $widget_promokod = DB::table('widget_metrika')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);

        DB::table('widget_metrika')->where('id', $widget_promokod->id)->update(
            [
                'counter' => $request->counter,


            ]);


        return 1;

    }

    public function update_tip_9($widget, $user, $request)
    {
        $widget_promokod = DB::table('widgets_email')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);

        DB::table('widgets_email')->where('id', $widget_promokod->id)->update(
            [
                'email' => $request->email,
                'server' => $request->server1,
                'login' => $request->login,
                'password' => $request->password,
                'element' => $request->element,
                'url' => $request->url

            ]);


        return 1;

    }

    public function update_tip_1($widget, $user, $request)
    {
        $widget_promokod = DB::table('widget_callback')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status, 'email' => $request->email]);


        $tags_array = explode(',', $request->tags);
        TagsController::addtag_widget($tags_array, $widget->id);
        return 1;

    }

    public function update_tip_0($widget, $user, $request)
    {
        $widget_promokod = DB::table('widgets_promokod')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);
        DB::table('widgets_promokod')->where('id', $widget_promokod->id)->update([
            'color' => $request->color,
            'background' => $request->background,
            'position_y' => $request->position_y,
            'position_x' => $request->position_x,


        ]);
        return 1;
    }

    public function update_tip_4($widget, $user, $request)
    {
        $widget_promokod = DB::table('widget_vk')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);
        DB::table('widget_vk')->where('id', $widget_promokod->id)->update([
            'apikey' => $request->apikey,
            'groupid' => $request->groupid,
            'confirmation' => $request->confirmation,


        ]);
        return 1;
    }

    public function update_tip_5($widget, $user, $request)
    {
        $widget_promokod = DB::table('widget_viber')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '1';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);
        DB::table('widget_viber')->where('id', $widget_promokod->id)->update([
            'apikey' => $request->apikey,

            'start_message' => $request->start_message,


        ]);

        $site = DB::table('sites')->where('id', $widget->sites_id)->first();
        $ViberApiController = new ViberApiController();
        return $ViberApiController->registerwebhook($site->hash, $request->apikey);

    }

    public function update_tip_6($widget, $user, $request)
    {
        $widget_promokod = DB::table('widget_ok')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '1';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);
        DB::table('widget_ok')->where('id', $widget_promokod->id)->update([
            'apikey' => $request->apikey,

            'start_message' => $request->start_message,


        ]);


        // https://api.ok.ru/graph/me/subscribe?access_token=tkn18YdUJZe:CQABPOJKAKEKEKEKE
        $OkApiController = new OkApiController();
        $otvet = $OkApiController->set_webhook($request->apikey, $widget->sites_id);
        $arrayotvet = json_decode($otvet);
        if (isset($arrayotvet->success)) {
            return 1;
        } else {
            return $otvet;
        }
        //return 1;
        /*  $site=DB::table('sites')->where('id',$widget->sites_id)->first();
          $ViberApiController=new ViberApiController();
          return $ViberApiController->registerwebhook($site->hash,$request->apikey);*/

    }

    public function update_tip_8($widget, $user, $request)
    {
        $widget_promokod = DB::table('widget_telegram')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '1';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);
        DB::table('widget_telegram')->where('id', $widget_promokod->id)->update([
            'apikey' => $request->apikey,

            'start_message' => $request->start_message,


        ]);


        // https://api.ok.ru/graph/me/subscribe?access_token=tkn18YdUJZe:CQABPOJKAKEKEKEKE
        $OkApiController = new TelegramController();
        $otvet = $OkApiController->set_webhook($request->apikey, $widget->sites_id);
        $arrayotvet = json_decode($otvet);
        if (isset($arrayotvet->success)) {
            return 1;
        } else {
            return $otvet;
        }
        //return 1;
        /*  $site=DB::table('sites')->where('id',$widget->sites_id)->first();
          $ViberApiController=new ViberApiController();
          return $ViberApiController->registerwebhook($site->hash,$request->apikey);*/

    }

    public function update_tip_7($widget, $user, $request)
    {
        $widget_promokod = DB::table('widget_fb')->where('my_company_id', $user->my_company_id)->where('id', $request->widget_promokod_id)->first();
        if (!$widget_promokod) {
            return '0';
        }
        Widgets::where('id', $widget->id)->update(['status' => $request->status]);
        DB::table('widget_fb')->where('id', $widget_promokod->id)->update([
            'apikey' => $request->apikey,

            'start_message' => $request->start_message,


        ]);

        return 1;
    }

    public function addphone(Request $request)
    {
        $user = Auth::user();
        $RunexisController = new RunexisController();

        $result=$RunexisController->bayphone($request->amount, $request->region, $request->widget_id, $user->my_company_id);
        return  $result ;

    }

    public function deletephone(Request $request)
    {
        $user=Auth::user();
        $prov = DB::table('widgets_phone')->where('my_company_id',$user->my_company_id)->where('widget_id', $request->widget_id)->where('input', $request->number)->first();
        if (!$prov) {
            return '';
        } else {
            $user = Auth::user();
            $RunexisController = new RunexisController();


            $numbers[] = substr($request->number, 1);

            $RunexisController->deleteNumber($numbers);
            $Asterisk=new AsteriskController();

            $Asterisk->deletete_number($request->number);

            $prov = DB::table('widgets_phone')->where('widget_id', $request->widget_id)->where('input', $request->number)->where('id', $request->ids)->delete();
            return '';
        }
    }
}
