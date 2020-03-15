<?php

namespace App\Http\Controllers;
use Validator;
use File;
use Log;
class ServiceCodes extends Controller
{
    static function uploadFile($file_request, $iamge_array, $path, $my_company_id)
    {

        $new_path = ServiceCodes::create_user_folder($my_company_id, $path);


        $data['status'] = 0;
        $data['path_file'] = '';
        $image = $file_request;

        $validator = Validator::make(['image' => $image], $iamge_array);

        if ($validator->fails()) {
            $data['status'] = 1;
            $data['path_file'] = 'Ошибка! Это не изображение';
            return json_encode($data);
        }

        $exp = File::extension($file_request->getClientOriginalName());
        $newname = md5(time() . '_' . $file_request->getClientOriginalName()) . '.' . $exp;

        $image->move($new_path, $newname);

        $data['status'] = 1;
        $data['path_file'] = $newname;
        return json_encode($data);
    }


    /**
     * @param $my_company_id
     * @param $path
     * @return string
     */
    static function create_user_folder($my_company_id, $path)
    {
        $new_path = base_path() . '/public/' . $path . '/' . $my_company_id . '/';
        if (!is_dir(base_path() . '/public/' . $path . '/' . $my_company_id . '/')) {
            mkdir($new_path);

        }

        return $new_path;


    }
}
