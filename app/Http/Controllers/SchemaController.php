<?php

namespace App\Http\Controllers;

use Schema;
use DB;
class SchemaController extends Controller
{
    public $my_company_id;


    public function index($my_company_id=null)
    {



$users=DB::table('users')->get();
foreach ($users as $u){
    $this->my_company_id =$u->my_company_id;
        $array_tables = ['direct_otchet','direct_otchet_parcer','adwords_otchet','adwords_otchet_parcer','create_metrika','create_metrika_update','update_adwords'];


        for ($i = 0; $i < count($array_tables); $i++) {

            switch ($array_tables[$i]) {



                case 'direct_otchet':

                $this->create_direct_otchet();

                    break;
                case 'direct_otchet_parcer':

                    $this->create_direct_otchet_parcer();

                    break;

                case 'adwords_otchet':

                    $this->create_adwords_otchet();

                    break;
                case 'adwords_otchet_parcer':

                    $this->create_adwords_otchet_parcer();

                    break;
                case 'create_metrika':

                    $this->create_metrika();

                    break;


                case 'create_metrika_update':

                    $this->create_metrika_update();

                    break;
                case 'update_adwords':

                    $this->update_adwords();

                    break;

            }


        }

    }
    }
    public function create_metrika_update(){




            if (!Schema::connection('neiros_metrica')->hasColumn('metrica_' . $this->my_company_id, 'cost')) {
                Schema::connection('neiros_metrica')->table('metrica_' . $this->my_company_id, function ($table)   {


                    $table->integer('cost')->nullable();
                    $table->index('cost');
                });
            }
            if (!Schema::connection('neiros_metrica')->hasColumn('metrica_' . $this->my_company_id, 'unique_visit')) {
                Schema::connection('neiros_metrica')->table('metrica_' . $this->my_company_id, function ($table)   {


                    $table->integer('unique_visit')->nullable();

                    $table->index('unique_visit');
                });
            }

        if (!Schema::connection('neiros_metrica')->hasColumn('metrica_' . $this->my_company_id, 'src_old')) {
            Schema::connection('neiros_metrica')->table('metrica_' . $this->my_company_id, function ($table)   {


                $table->string('src_old', 255)->nullable();

                $table->index('src_old');
            });
        }


    }
    public function update_adwords(){




        if (!Schema::connection('neiros_cloud_adwords')->hasColumn('adwords_otchet_parcer_' . $this->my_company_id, 'site_id')) {
            Schema::connection('neiros_cloud_adwords')->table('adwords_otchet_parcer_' . $this->my_company_id, function ($table)   {


                $table->integer('site_id')->nullable();
                $table->index('site_id');
            });
        }




    }
    public function create_adwords_otchet(){

        if (!Schema::connection('neiros_cloud_adwords')-> hasTable('otchet_' . $this->my_company_id))

            Schema::connection('neiros_cloud_adwords')->create('otchet_' . $this->my_company_id, function ($table) {
                $table->increments('id');
                $table->integer('direct_company_id')->nullable();
                $table->string('name', 255)->nullable();
                $table->integer('status')->nullable();
                $table->date('DateFrom')->nullable();;
                $table->date('DateTo')->nullable();;
                $table->date('created_at')->nullable();
                $table->date('updated_at')->nullable();
                $table->integer('first_otchet')->nullable();
                $table->string('comment', 255)->nullable();
            });

        }


    public function create_metrika(){

        if (!Schema::connection('neiros_metrica')-> hasTable('metrica_' . $this->my_company_id))

            Schema::connection('neiros_metrica')->create('metrica_' . $this->my_company_id, function ($table) {
                $table->increments('id');
                $table->string('key_user', 255)->nullable();
                $table->datetime('fd')->nullable();;
                $table->datetime('created_at')->nullable();;
                $table->datetime('updated_at')->nullable();;

                $table->text('ep')->nullable();;
                $table->string('rf',5000)->nullable();;
                $table->string('typ',500)->nullable();;
                $table->string('src',500)->nullable();;
                $table->string('mdm',500)->nullable();;
                $table->string('cmp',500)->nullable();;
                $table->string('cnt',500)->nullable();;
                $table->string('hash',500)->nullable();;
                $table->string('uag',500)->nullable();;
                $table->string('utm_source',500)->nullable();;
                $table->string('user_id',500)->nullable();;
                $table->string('trim',255)->nullable();;
                $table->integer('visit')->nullable();;
                $table->string('promocod',255)->nullable();;
                $table->integer('project_id')->nullable();;
                $table->string('_ym_uid',255)->nullable();;
                $table->string('_gid',255)->nullable();;
                $table->string('olev_phone_track',255)->nullable();;
                $table->string('ip',255)->nullable();;
                $table->integer('region')->nullable();;
                $table->integer('my_company_id')->nullable();;
                $table->integer('site_id')->nullable();;

                $table->date('reports_date')->nullable();;
                $table->integer('bot')->nullable();;
                $table->integer('social')->nullable();;
                $table->integer('reklama')->nullable();;
                $table->integer('sdelka')->nullable()->default(0);;;//0
                $table->integer('lead')->nullable()->default(0);;;//0
                $table->integer('summ')->nullable()->default(0);;;//0
                $table->integer('widget_id')->nullable()->default(0);;//0
                $table->string('sub_widget',255)->nullable();;
                $table->integer('neiros_visit')->nullable()->default(0);;//0
                $table->integer('uploaded')->nullable()->default(0);;//0



                $table->index('typ');
                $table->index('src');
                $table->index('visit');
                $table->index('project_id');
                $table->index('site_id');
                $table->index('reports_date');
                $table->index('bot');
                $table->index('sdelka');
                $table->index('lead');
                $table->index('summ');
                $table->index('neiros_visit');



            });

    }


    public function create_direct_otchet_parcer()
    {
        if (!Schema::connection('neiros_direct1')->hasTable('direct_otchet_parcer_' . $this->my_company_id))
        {


            Schema::connection('neiros_direct1')->create('direct_otchet_parcer_' . $this->my_company_id, function ($table) {
                $table->increments('id');
                $table->date('created_at')->nullable();
                $table->date('updated_at')->nullable();
                $table->string('CampaignId', 255)->nullable();
                $table->string('CampaignName', 255)->nullable();
                $table->string('AdGroupId', 255)->nullable();
                $table->string('AdGroupName', 255)->nullable();
                $table->string('Query', 255)->nullable();
                $table->date('Date' )->nullable();
                $table->bigInteger('Cost' )->nullable();
                $table->string('Criteria', 255)->nullable();
                $table->string('AdId', 255 )->nullable();
                $table->string('AdNetworkType', 255 )->nullable();

                $table->string('Bounces', 255 )->nullable();
                $table->string('Clicks', 255 )->nullable();
                $table->string('Impressions', 255 )->nullable();
                $table->string('Placement', 255 )->nullable();




                $table->integer('my_company_id' )->nullable();
                $table->integer('otchet' )->nullable();




            });

        }
    }


    public function create_direct_otchet()
    {


 if (!Schema::connection('neiros_direct1')->hasTable('direct_otchet_' . $this->my_company_id))
{


        Schema::connection('neiros_direct1')->create('direct_otchet_' . $this->my_company_id, function ($table) {
            $table->increments('id');
            $table->integer('direct_company_id')->nullable();
            $table->string('name', 255)->nullable();
            $table->integer('status')->nullable();
            $table->date('DateFrom')->nullable();;
            $table->date('DateTo')->nullable();;
            $table->date('created_at')->nullable();
            $table->date('updated_at')->nullable();
            $table->integer('first_otchet')->nullable();
            $table->string('comment', 255)->nullable();
            $table->string('file_name', 255)->nullable();
            $table->integer('status_upload')->nullable();
        });

}
    }

    public function create_adwords_otchet_parcer()
    {
        if (!Schema::connection('neiros_cloud_adwords')->hasTable('adwords_otchet_parcer_' . $this->my_company_id))
        {
            Schema::connection('neiros_cloud_adwords')->create('adwords_otchet_parcer_' . $this->my_company_id, function ($table) {
                $table->increments('id');
                $table->date('created_at')->nullable();
                $table->date('updated_at')->nullable();
                $table->string('CampaignId', 255)->nullable();
                $table->string('CampaignName', 255)->nullable();
                $table->string('AdGroupId', 255)->nullable();
                $table->string('AdGroupName', 255)->nullable();
                $table->string('Query', 255)->nullable();
                $table->date('Date' )->nullable();
                $table->bigInteger('Cost' )->nullable();
                $table->string('Criteria', 255)->nullable();
                $table->string('AdId', 255 )->nullable();
                $table->string('AdNetworkType1', 255 )->nullable();
                $table->string('AdNetworkType2', 255 )->nullable();

                $table->string('Bounces', 255 )->nullable();
                $table->string('Clicks', 255 )->nullable();




                $table->integer('my_company_id' )->nullable();
                $table->integer('otchet' )->nullable();




            });

        }
    }

    /* if (!Schema::hasColumn('X_oil_template_grease', $poles)) {
                     Schema::table('X_oil_template_grease', function ($table) use ($poles) {

                         $table->longText($poles)->nullable();


                     });
                 }*/
}
