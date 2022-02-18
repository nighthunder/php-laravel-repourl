<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class HomeController extends Controller {

    public function redirect()
    {
        if (Auth::check()) 
            return Redirect::route('dashboard');

        return Redirect::route('login');
    }

}