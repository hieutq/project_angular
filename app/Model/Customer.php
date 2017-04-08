<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Customer extends Model
{
     use SoftDeletes;
     protected $table = 'customers';
     protected $fillable = ['name','gender','age','address','photo','status'];
}
