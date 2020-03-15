<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\SchemaController;
use App\Http\Controllers\StagesController;
use App\Models\Servies\GroupRoleUser;
use DB;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\User_roles;
use App\Http\Controllers\AdminTMController;
use App\Models\Admin_template_messages;
use App\Http\Controllers\RunexisController;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'g-recaptcha-response' => 'recaptcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $companyId=DB::table('users_company')->insertgetId(['name'=>$data['company']]);

$sms_code=rand(1111,9999);




        $user= User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
            'test_period' => 1,
            'role' => 0,
            'my_company_id'=> $companyId,
            'apikey'=>md5(time().rand(1,10000)),
            'start_date'=>date('Y-m-d'),
            'end_date'=>date('Y-m-d'),
            'stat_start_date'=>date('Y-m-d'),
            'stat_end_date'=>date('Y-m-d'),
            'is_active'=>0,
            'sms_code'=>$sms_code,
            'amount_sms'=>1,
            'time_sms'=>time(),
            'is_first_reg'=>1,
            'partner_id'=> $data['partner_id'],
        ]);



StagesController::create_default_stage($companyId);

        for($i=0;$i<=3;$i++){

            User_roles::insert([
                'modul' => $i,
                'user_id' => $user->id,
                'create' =>1,
                'read' =>1,
                'edit' =>1,
                'delete' => 1,
            ]);

        }
        $ugrup = new GroupRoleUser();
        $ugrup->user_id = $user->id;
        $ugrup->group_id = 0;
        $ugrup->save();
        $chema=new SchemaController();
        $chema->index();


        $AdminTMController=new AdminTMController();
        $AdminTMController->send_mail($user,0);
try{
    $RunexisController=new RunexisController();
    $RunexisController->send_sms($sms_code, $data['phone']);
}catch (\Exception $e){


}
       return $user;
    }
}
