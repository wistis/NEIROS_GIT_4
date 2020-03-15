<?php

namespace App\Console\Commands;
use DB;
use Illuminate\Console\Command;
use Log;

class Texttobase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:texttobase {audioid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Log::info('starttranslate');

        $id = $this->argument('audioid');
        $cal = DB::connection('asterisk')->table('calls')->where('id', $id)->first();

        $in_audioname_in_p = "/var/www/neiros/data/www/cloud.neiros.ru/public/audiorecord/" . $cal->record_file . '-in.mp3.txt';
        $in_audioname_out_p = "/var/www/neiros/data/www/cloud.neiros.ru/public/audiorecord/" . $cal->record_file . '-out.mp3.txt';
        $handle = fopen("$in_audioname_in_p", "r");
        $i = 0;
        $data = [];
        while (!feof($handle)) {
            $buffer = fgets($handle, 4096);
            /*INSERT INTO `input_call_text`(`id`, `text`, `time`, `operator`, `in_id`, `created_at`, `updated_at`)*/


            if ($i == 0) {
                $data['text'] = $buffer;

            }
            if ($i == 1) {
                $data['time'] = $buffer;
                $time_ar=explode(' to ',$buffer);
                $tstart=round(str_replace('from','',$time_ar[0]));
                $tend=round($time_ar[1]);
                $data['tstart']=$tstart;
                $data['tend']=$tend;
                $timers=strtotime($cal->calldate)+($tstart-$tend);
                $data['timers']=date('Y-m-d H:i:s',$timers);



                $data['operator'] = 0;
                $data['in_id'] = $id;
                DB::table('input_call_text')->insert($data);

                $data = [];

            }
            $i++;
            if ($i > 1) {
                $i = 0;
            }


        }


        fclose($handle);

        $handle = fopen("$in_audioname_out_p", "r");
        $data = [];$i=0;
        while (!feof($handle)) {
                $buffer = fgets($handle, 4096);
            /*INSERT INTO `input_call_text`(`id`, `text`, `time`, `operator`, `in_id`, `created_at`, `updated_at`)*/


            if ($i == 0) {
                $data['text'] = $buffer;


            }
            if ($i == 1) {

                $data['time'] = $buffer;
                $time_ar=explode(' to ',$buffer);
                $tstart=round(str_replace('from','',$time_ar[0]));
                $tend=round($time_ar[1]);
                $data['tstart']=$tstart;
                $data['tend']=$tend;
                $timers=strtotime($cal->calldate)+($tstart-$tend);
                $data['timers']=date('Y-m-d H:i:s',$timers);







                $data['operator'] = 1;
                $data['in_id'] = $id;
                DB::table('input_call_text')->insert($data);

                $data = [];

            }
            $i++;
            if ($i > 1) {
                $i = 0;
            }


        }


        fclose($handle);
    }
}
