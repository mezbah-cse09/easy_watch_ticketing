<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    function home(){
        return response()->json([
            'status' => 'success',
            'message' => 'Customer dashboard'

        ],200);
    }
}
