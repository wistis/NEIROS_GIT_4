<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;

class FormBuildnerController extends Controller
{

    public function get_parent_form($id){
$user=Auth::user();
        return DB::table('widgets_popup_form')->where('parent_id', $id)->where('my_company_id', $user->my_company_id)->get();


    }
    //
    public function createform($id, $pop = null)
    {
        $user = Auth::user();
        $data['user'] = $user;
        $data['widget_osn'] = DB::table('widgets_popup')->where('id', $id)->where('my_company_id', $user->my_company_id)->first();
        $data['widget_form_id'] = 0;
        $data['widget_form_name'] = '';
        $data['json'] = '';
        if (!is_null($pop)) {
            $df = DB::table('widgets_popup_form')->where('id', $pop)->where('my_company_id', $user->my_company_id)->first();


            if ($df) {
                $data['json'] = $df->json_form;
                $data['widget_form_id'] = $df->id;
                $data['widget_form_name'] = $df->name;
            }


        }


        return view('widgets.formbuidner', $data);
    }

    /*ALTER TABLE `widgets_popup` ADD `html_form` LONGTEXT NULL AFTER `create_project`, ADD `json_form` LONGTEXT NULL AFTER `html_form*/

    public function doform(Request $request)
    {

        if ($request->tip == 'safe') {
            return $this->safeform($request);
        }

        if ($request->tip == 'view') {
            return $this->getfromid($request->id);
        }
        if ($request->tip == 'deleteform') {
            return $this->deleteform($request->id);
        }
        if ($request->tip == 'settingpopupform') {
            return $this->settingpopupform($request->id);
        }
        if ($request->tip == 'settingpopupformsafe') {
            return $this->settingpopupformsafe($request);
        }
        if ($request->tip == 'createab') {
            return $this->createab($request->id);
        }

    }

    public function createab($id){
$user=Auth::user();

        $df = DB::table('widgets_popup_form')->where('id', $id)->where('my_company_id', $user->my_company_id)->first();

        DB::table('widgets_popup_form')->where('id', $id)->where('my_company_id', $user->my_company_id)->update(['is_ab'=>1]);

$new_form=DB::table('widgets_popup_form')->insertGetId([
    'widget_popup_id' => $df->widget_popup_id,
    'my_company_id' => $df->my_company_id,
    'user_id' => $df->user_id,
    'widget_id' => $df->widget_id,
    'html_form' => $df->html_form,
    'json_form' => $df->json_form,
    'name' => $df->name.' A/B',
    'parent_id' =>$id
]);


        $poles= DB::table('widgets_popup_template_pole')->where('form_id',$id)->get();
        foreach ($poles as $field){



            $data_array['pole_id'] = $field->pole_id;
            $data_array['tag'] = $field->tag;
            $data_array['form_id'] = $new_form;
            $data_array['doit'] = $field->doit;
            $data_array['my_company_id'] =$df->my_company_id;

                $data_array['tag'] = $field->tag;
            DB::table('widgets_popup_template_pole')->insert($data_array);


        }
        return $new_form;
    }

    public function settingpopupformsafe($request){
         $settingpopupform_id=$request->settingpopupform_id;
        DB::table('widgets_popup_form')->where('id',$request->settingpopupform_id)->update([
            'timer'=>$request->timer
        ]);
       foreach ($request->all() as $key=>$value){


          DB::table('widgets_popup_template_pole')->where('form_id',$settingpopupform_id)
          ->where('pole_id',$key)->update([
              'doit'=>$value
              ]);

        }
    }

    public function settingpopupform($id){

$poles= DB::table('widgets_popup_template_pole')->where('form_id',$id)->get();
$wid= DB::table('widgets_popup_form')->where('id',$id)->first();
$datatext='<input type="hidden" name="settingpopupform_id" value="'.$id.'">
<div class="col-md-6">Время показа</div>
<div class="col-md-6"><input type="text" name="timer" value="'.$wid->timer.'"></div>
';

foreach ($poles as $pole){

    $datatext.='<div class="row" style="margin: 5px">

<div class="col-md-6">'.$pole->tag.'</div>
<div class="col-md-6">
<select name="'.$pole->pole_id.'" class="form-control">
<option value="0" '.($pole->doit == 0 ? 'selected' : '').'>Не выбрано</option>
<option value="1" '.($pole->doit == 1 ? 'selected' : '').'>Поле E-mail</option>
<option value="2" '.($pole->doit == 2 ? 'selected' : '').'>Поле Телефона</option>
<option value="3" '.($pole->doit == 3 ? 'selected' : '').'>Поле Имени</option>
<option value="4" '.($pole->doit == 4 ? 'selected' : '').'>Поле Города</option>
<option value="5" '.($pole->doit == 5 ? 'selected' : '').'>Кнопка отправки</option>
<option value="6" '.($pole->doit == 6 ? 'selected' : '').'>Кнопка отмены</option>


</select>


</div>
</div>


';
}


return $datatext;






    }

    public function getfromid($id)
    {
        $data = DB::table('widgets_popup_form')->where('id', $id)->first();
        return $data->html_form;


    }

    public function safeform($data)
    {
        $user = Auth::user();
        /*      id:$('#widget_id').val(),
        json_form:$('.render-form').html(),
        html_form:formeo.formData,
        name:$('#name_form').val(),
        widget_fid:$('#widget_form_id').val()*/
        if ($data->widget_fid == 0) {
            $da = DB::table('widgets_popup')->where('id', $data->id)->where('my_company_id', $user->my_company_id)->first();


            /*INSERT INTO `widgets_popup_form`(`id`, `widget_id`, `widget_popup_id`, `my_company_id`, `user_id`, `updated_at`, `created_at`, `create_project`, `html_form`, `json_form`)*/
            $ids = DB::table('widgets_popup_form')->insertGetId([
                'widget_id' => $da->widget_id,
                'widget_popup_id' => $da->id,
                'my_company_id' => $da->my_company_id,
                'user_id' => $user->id,
                'html_form' => $data->json_form,
                'json_form' => $data->html_form,
                'name' => $data->name,
            ]);


            $this->create_pole($ids, 0);
            return $ids;

        } else {
            DB::table('widgets_popup_form')->where('id', $data->widget_fid)->update([


                'html_form' => $data->json_form,
                'json_form' => $data->html_form, 'name' => $data->name,
            ]);

          $this->create_pole($data->widget_fid, 1);
            return $data->widget_fid;
        }


    }

    public function deleteform($id){
$user=Auth::user();

$getform= DB::table('widgets_popup_form')->where('id', $id)->where('my_company_id', $user->my_company_id)->first();

        DB::table('widgets_popup_form')->where('id', $id)->where('my_company_id', $user->my_company_id)->delete();
        DB::table('widgets_popup_template_pole')->where('form_id',$id)->delete();
if($getform->parent_id>0){
    DB::table('widgets_popup_form')->where('id', $getform->parent_id)->where('my_company_id', $user->my_company_id)->update(['is_ab'=>0]);
}

    }
    public function create_pole($id, $tip)
    {
        $data = DB::table('widgets_popup_form')->where('id', $id)->first();
        $newdata = json_decode($data->json_form);
        if ($tip == 0) {
            $i = 0;
            $data_array = [];
            //  dd($newdata->fields);

            $dataj=$data->json_form;
            $datah=$data->html_form;

            foreach ($newdata->fields as $field) {


                $data_array[$i]['pole_id'] =  $field->id;
                $data_array[$i]['tag'] = $field->tag;
                $data_array[$i]['form_id'] = $id;
                $data_array[$i]['doit'] = 0;
                $data_array[$i]['my_company_id'] = $data->my_company_id;
                if ($field->tag == 'button') {
                    $data_array[$i]['tag'] = $field->options[0]->label;
                }
                if ($field->tag == 'input') {
                    $data_array[$i]['tag'] = $field->config->label;
                }
                $i++;
            }
            DB::table('widgets_popup_template_pole')->insert($data_array);
            DB::table('widgets_popup_form')->where('id', $id)->update([
               'json_form'=>$dataj,
               'html_form'=>$datah,
            ]);
        }
        if ($tip == 1) {
            $getpoles = DB::table('widgets_popup_template_pole')->where('form_id', $id)->get();

            $get_ids = [];


            foreach ($newdata->fields as $field) {
                $get_ids[] = $field->id;

            }
            foreach ($getpoles as $getpole) {
                if (!in_array($getpole->pole_id, $get_ids)) {
                    DB::table('widgets_popup_template_pole')->where('form_id', $id)->where('id', $getpole->id)->delete();
                }



                foreach ($newdata->fields as $field) {
                    $prov_pole=DB::table('widgets_popup_template_pole')->where('form_id', $id)->where('pole_id', $field->id)->first();
                    if($prov_pole){
                        if ($field->tag == 'button') {
                            $tag = $field->options[0]->label;
                        }
                        if ($field->tag == 'input') {
                            $tag = $field->config->label;
                        }


                        DB::table('widgets_popup_template_pole')->where('form_id', $id)->where('id', $prov_pole->id)->update([
                            'tag'=>$tag
                        ])  ;

                    }else{



                    $data_array['pole_id'] = $field->id;
                    $data_array['tag'] = $field->tag;
                    $data_array['form_id'] = $id;
                    $data_array['doit'] = 0;
                        $data_array['my_company_id'] =$data->my_company_id;
                    if ($field->tag == 'button') {
                        $data_array['tag'] = $field->options[0]->label;
                    }
                    if ($field->tag == 'input') {
                        $data_array['tag'] = $field->config->label;
                    }
                        DB::table('widgets_popup_template_pole')->insert($data_array);


                    }
                }








            }


        }

    }
    /*INSERT INTO `widgets_popup_template_pole`(`id`, `pole_id`, `doittip`, `doit`, `created_at`, `updated_at`)*/
}
