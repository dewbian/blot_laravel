<?php

namespace App\Http\Controllers;

use App\message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(){ 

        $messages = message::where(function($query){
            $query -> where('from', request( 'from' ) );
            $query -> where('to', request( 'to' ) );
        })-> orWhere( function ($query) {            
            $query -> where('from', request( 'to' ) );
            $query -> where('to', request( 'from' ) );
        })-> get();

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
