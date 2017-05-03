<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Customer;

class CustomersController extends Controller
{
    public function getList()
    {
        return Customer::orderby('id', 'DESC')->get();
    }
}
