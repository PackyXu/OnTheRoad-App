<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $table ='messages';

    protected $fillable = ['from_user_id','to_user_id','msg_content','dialog_id'];

    public function fromUser ()
    {
        return $this->belongsToMany(User::class,'from_user_id');
    }

    public function toUser ()
    {
        return $this->belongsToMany(User::class,'to_user_id');
    }

}
