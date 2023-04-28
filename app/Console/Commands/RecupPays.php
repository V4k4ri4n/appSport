<?php

namespace App\Console\Commands;

use App\Models\Pays;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class RecupPays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:recup-pays';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reponse = json_decode(Http::accept('application/json')
                        ->withHeaders(['x-rapidapi-host' => env('API_FOOTBALL_URL'),
                             'x-rapidapi-key' => env('API_SPORT_KEY')])
                        ->get("https://v3.football.api-sports.io/countries")
                        ->body());
        if(count($reponse->errors) > 0){
           Log::error('Une erreur est survenue lors de la récupération des informations :'.$reponse->errors);
        }else{
            $tabPays = $reponse->response;
            if(count($tabPays) > 0){
                foreach($tabPays as $pays){
                    if($pays->name == "World"){
                        $InsertOrUpdatePays = Pays::firstWhere('nom',"World");
                        if(!isset($InsertOrUpdatePays)) $InsertOrUpdatePays = new Pays();
                    }else{
                        $InsertOrUpdatePays = Pays::firstWhere([['code',$pays->code],['nom',$pays->name]]);
                        if(!isset($InsertOrUpdatePays)) $InsertOrUpdatePays = new Pays();
                    }
                    $InsertOrUpdatePays->nom     = $pays->name;
                    $InsertOrUpdatePays->code    = $pays->code;
                    $InsertOrUpdatePays->drapeau = $pays->flag;
                    $InsertOrUpdatePays->save();
                }
            }
        }
    }
}
