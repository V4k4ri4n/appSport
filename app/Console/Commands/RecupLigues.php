<?php

namespace App\Console\Commands;

use App\Models\Ligue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class RecupLigues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:recup-ligues';

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
        $pays = "france";
        $reponse = json_decode(Http::accept('application/json')
        ->withHeaders(['x-rapidapi-host' => env('API_FOOTBALL_URL'),
             'x-rapidapi-key' => env('API_SPORT_KEY')])
        ->get("https://v3.football.api-sports.io/leagues?country=".$pays)
        ->body());

        if(count($reponse->errors) > 0){
            Log::error('Une erreur est survenue lors de la récupération des informations :'.$reponse->errors);
         }else{
             $tabLigues = $reponse->response;
             if(count($tabLigues) > 0){
                 foreach($tabLigues as $ligue){
                    $InsertOrUpdateLigue = Ligue::firstWhere('ligue_id',$ligue->league->id);
                    if(!isset($InsertOrUpdateLigue)) $InsertOrUpdateLigue = new Ligue();
                    $InsertOrUpdateLigue->ligue_id = $ligue->league->id;
                    $InsertOrUpdateLigue->nom      = $ligue->league->name;
                    $InsertOrUpdateLigue->type     = $ligue->league->type;
                    $InsertOrUpdateLigue->type     = $ligue->league->type;
                    $InsertOrUpdateLigue->logo     = $ligue->league->logo;
                    $InsertOrUpdateLigue->save();
                 }
             }
         }
    }
}
