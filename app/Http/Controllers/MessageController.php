<?php

namespace App\Http\Controllers;

use App\message;
use Illuminate\Http\Request;
use Log;
class MessageController extends Controller
{
    public function index(){ 

        //Log::info("1111111111111111111111111111111") ;
        $messages = message::where(function($query){
            $query -> where('from', request( 'from' ) );
            $query -> where('to', request( 'to' ) );
        })-> orWhere( function ($query) {            
            $query -> where('from', request( 'to' ) );
            $query -> where('to', request( 'from' ) );
        })-> get();
        //Log::info("2222222222222222222222222222222") ;
        return response()->json([
            "messages" => $messages->load('from','to')
        ], 200);

    }

    public function store(){
 
        $validated = request()->validate([
            'text' => 'required',
            'to' => 'required',
            'from' => 'required', 
        ]);

        $message_result = message::create($validated);

        return response() -> json([
            'message_result' => $message_result
        ] );

 

    } 
}
