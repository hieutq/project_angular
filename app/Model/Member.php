<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Member extends Model
{
    use SoftDeletes;
     protected $table = 'members';
     protected $fillable = ['name','gender','age','address','photo','status'];
}
