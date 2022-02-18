<?php

class DashboardController extends Controller {

    public function show()
    {
        if (Auth::guest()) 
            return Redirect::route('login');

        return View::make('dashboard');
    }

}