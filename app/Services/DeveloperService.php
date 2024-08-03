<?php

namespace App\Services;
use App\Models\Developer;
class DeveloperService
{

    public function get(){

        return Developer::first();

    }

}
