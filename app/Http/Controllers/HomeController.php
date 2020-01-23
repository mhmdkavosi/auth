<?php

namespace App\Http\Controllers;

use App\AccessModule;
use App\ItemModule;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    public function test(){
        return \response()->json(['message'=>'access']);
    }
}
