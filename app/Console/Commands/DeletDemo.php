<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class DeletDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deletdemo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получить ключи метрики';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table('Advertising_channel')->where('my_company_id', 22)->delete();
        DB::table('bay_phones')->where('my_company_id', 22)->delete();
        DB::table('chat_tema')->where('my_company_id', 22)->delete();
        DB::table('chat_with_client')->where('my_company_id', 22)->delete();
        DB::table('Checkcompanys')->where('my_company_id', 22)->delete();
        DB::table('clients')->where('my_company_id', 22)->delete();
        DB::table('companies')->where('my_company_id', 22)->delete();
        DB::table('Costs')->where('my_company_id', 22)->delete();
        DB::table('direct_company')->where('my_company_id', 22)->delete();
        DB::table('field_tip')->where('my_company_id', 22)->delete();
        DB::table('field_tip_param')->where('my_company_id', 22)->delete();

        DB::table('metrika_counter')->where('my_company_id', 22)->delete();
        DB::table('metrika_direct_company')->where('my_company_id', 22)->delete();
        DB::table('metrika_keywords_import')->where('my_company_id', 22)->delete();
        DB::table('neiros_hash_fields')->where('my_company_id', 22)->delete();
        DB::table('pay_company')->where('my_company_id', 22)->delete();
        DB::table('Phscript')->where('my_company_id', 22)->delete();
        DB::table('projects')->where('my_company_id', 22)->delete();
        DB::table('projects_tags')->where('my_company_id', 22)->delete();
        DB::table('project_logs')->where('my_company_id', 22)->delete();
        DB::table('sites')->where('my_company_id', 22)->delete();
        DB::table('stages')->where('my_company_id', 22)->delete();
        DB::table('tags')->where('my_company_id', 22)->delete();
        DB::table('widgets')->where('my_company_id', 22)->delete();
        DB::table('widgets_chat')->where('my_company_id', 22)->delete();
        DB::table('widgets_chat_social_click')->where('my_company_id', 22)->delete();
        DB::table('widgets_chat_url_operator')->where('my_company_id', 22)->delete();
        DB::table('widgets_email')->where('my_company_id', 22)->delete();
        DB::table('widgets_email_input')->where('my_company_id', 22)->delete();
        DB::table('widgets_phone')->where('my_company_id', 22)->delete();
        DB::table('widgets_phone_routing')->where('my_company_id', 22)->delete();
        DB::table('widgets_popup')->where('my_company_id', 22)->delete();
        DB::table('widgets_popup_form')->where('my_company_id', 22)->delete();

        DB::table('widgets_popup_template_pole')->where('my_company_id', 22)->delete();
        DB::table('widgets_promokod')->where('my_company_id', 22)->delete();
        DB::table('widget_callback')->where('my_company_id', 22)->delete();
        DB::table('widget_callback_form')->where('my_company_id', 22)->delete();
        DB::table('widget_call_track')->where('my_company_id', 22)->delete();
        DB::table('widget_chat_input')->where('my_company_id', 22)->delete();
        DB::table('widget_chat_users')->where('my_company_id', 22)->delete();
        DB::table('widget_direct')->where('my_company_id', 22)->delete();
        DB::table('widget_fb')->where('my_company_id', 22)->delete();
        DB::table('widget_fb_users')->where('my_company_id', 22)->delete();
        DB::table('widget_fb_input')->where('my_company_id', 22)->delete();
        DB::table('widget_metrika')->where('my_company_id', 22)->delete();
        DB::table('widget_ok')->where('my_company_id', 22)->delete();
        DB::table('widget_ok_input')->where('my_company_id', 22)->delete();
        DB::table('widget_ok_users')->where('my_company_id', 22)->delete();
        DB::table('widget_tags')->where('my_company_id', 22)->delete();
        DB::table('widget_telegram')->where('my_company_id', 22)->delete();
        DB::table('widget_telegram_input')->where('my_company_id', 22)->delete();
        DB::table('widget_telegram_users')->where('my_company_id', 22)->delete();
        DB::table('widget_viber_input')->where('my_company_id', 22)->delete();
        DB::table('widget_viber_users')->where('my_company_id', 22)->delete();
        DB::table('widget_viber')->where('my_company_id', 22)->delete();
        DB::table('widget_vk')->where('my_company_id', 22)->delete();
        DB::table('widget_vk_input')->where('my_company_id', 22)->delete();
        DB::table('widget_vk_users')->where('my_company_id', 22)->delete();


    }
}
