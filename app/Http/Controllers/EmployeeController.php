<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    function home(){
        return response()->json([
            'status' => 'success',
            'message' => 'Employee dashboard'
        ],200);
    }
}
