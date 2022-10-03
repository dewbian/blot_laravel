<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    //
    protected $table = "messages";
    protected $guarded = [];


    public function from(){
        return $this ->belongsTo ( User::class, 'from');
    }

    public function to(){
        return $this ->belongsTo ( User::class, 'to');
    }


}
