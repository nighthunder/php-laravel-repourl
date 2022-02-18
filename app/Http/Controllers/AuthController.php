<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Redirect;
use Illuminate\Models\User;
use Carbon\Carbon;
use App\Http\Controllers\UserController;
class AuthController extends Controller
{
    //
    public function dashboard(){

        if(Auth::check() === true){
            //dd(Auth::user());
            $urls = DB::table('urls')->get();
            return view('admin.dashboard')->with(['urls' => $urls]);
            
        }

        return redirect()->route("dashboard.login");
    }

    public function showLoginForm(){
        return view("auth.login");
    }   

    public function login(Request $request){

        if ( ! filter_var($request->email, FILTER_VALIDATE_EMAIL) ){
            return redirect()->back()->withInput()->withErrors('Digite um email válido');
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        //Auth::attempt($credentials);
        if( Auth::attempt($credentials)){
            return redirect()->route('dashboard');
        }

        return redirect()->back()->withInput()->withErrors('Não existe uma conta com esses dados.');
    }

    public function loggout(){
        Auth::logout();
        
        return redirect()->route("login");
    }

    public function register(Request $request) {

        $users = DB::table('users')->get();
        //$users_id = \App\Models\User::latest()->first()->id;
        $users_id = $users->last()->id + 1;

        if(empty($request->name)){
            return redirect()->back()->withInput()->withErrors('Digite um nome.');
        }

        if(empty($request->email)){
            return redirect()->back()->withInput()->withErrors('Digite um email.');
        }

        if(empty($request->password)){
            return redirect()->back()->withInput()->withErrors('Digite uma senha.');
        }

        if ( ! filter_var($request->email, FILTER_VALIDATE_EMAIL) ){
            return redirect()->back()->withInput()->withErrors('Digite um email válido');
        }

        if (strcmp($request->password,$request->password_confirmation) !== 0){
            return redirect()->back()->withInput()->withErrors('As senhas não conferem');
        }

        $current = Carbon::now();

        $new_user = [
            'id' => $users_id,
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => $current,
            'password' => bcrypt($request->password),
            'remember_token' => Hash::make(Str::random(30)),
            'created_at' => $current,
            'updated_at' => $current
        ];

        //dd($new_user);

        $ret = DB::select('Insert into users values (?,?,?,?,?,?,?,?)', array_values($new_user));

        if(!$ret) {
            return redirect()->back()->withInput()->withErrors('Usuário registrado com sucesso.');
        } 

        return redirect()->back()->withInput()->withErrors('Ocorreu um problema ao registrar.');
    }
}
