<?php

namespace App\Jobs;
use App\Http\Controllers\AmoCrmApiController;
use App\Models\AmoWebhook;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AmoCrmWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $amowebhook;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AmoWebhook $AmoWebhook)
    {
        $this->amowebhook = $AmoWebhook;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       $amo=$this->amowebhook;

       try {
           $newAmo = new AmoCrmApiController();
           $newAmo->webhookreload($amo);
       }catch (\Exception $e){
           
       };


    }
}
