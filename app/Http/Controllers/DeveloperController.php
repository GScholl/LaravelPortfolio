<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DeveloperService;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    private $developerService;
    public function __construct(){

        $this->developerService = new DeveloperService;
    }

    public function get(){
        $developer = $this->developerService->get();

        if(!$developer){

            return response()->json([
                "message" => "Não há nenhum desenvolvedor Cadastrado"
            ],404);
        }
        return response()->json($developer,200);
    }
}
