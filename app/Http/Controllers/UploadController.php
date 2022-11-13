<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller{
 
    public function page(){
        return view('page'); 
    }


    public function upload(Request $request){

        $request->file('uploadFile')->store('images', 'public');
        //$file = $request->uploadFile->store('images');
        return redirect()->route('page11');
    }
}