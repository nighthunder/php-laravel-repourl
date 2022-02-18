<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UrlController extends Controller
{
    //
    public function paginacaoAjax(){
        $urls = DB::table('urls')->get();
        return DataTables::of($urls)->make(true);
    }

    public function do(Request $request){

        if($request->ajax()){
            $request_url = $request->get('query');

            $urls = DB::table('urls')->get();
            $urls_id = $urls->last()->id + 1;
    
            $current= Carbon::now();
            $url = [
                'id' => $urls_id,
                'url' => $request_url,
                'created_at' => $current
            ];    
            $ret = DB::select('Insert into urls values (?,?,?)', array_values($url));
            $urls = DB::table('urls')->get();
            //return DataTables::of($urls)->make(true);
            echo json_encode($urls);
        }
       
    }
}
