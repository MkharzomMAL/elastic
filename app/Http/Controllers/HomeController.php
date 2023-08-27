<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(){

        Log::info('NEW LOGS IN ELASTIC');

        return view('welcome');

        
    }
}
