<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormSubscription extends Model
{

    protected $table = "form_subscription";

    public $timestamps = false;

    public $fillable = [
    	"user_email"
    ];
}
