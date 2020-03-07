<?php

namespace App\Http\Controllers;

use App\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MainController extends Controller
{
    protected $api_url;
    protected $token;

    public function __construct()
    {
        $this->api_url = 'https://api.freelancehunt.com/v2/';
        $this->token = env('FHUNT_TOKEN');
    }

    public function test()
    {
        $project = Project::first();

        dd( $project->skills );
    }

    public function projects()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get($this->api_url . 'projects?page[number]=5');

        //dd($response['data']);

        if(isset($response['data'])){
            $model = new Project;
            foreach($response['data'] as $project){
                $model->parseApi($project);
            }
        }
    }
}
