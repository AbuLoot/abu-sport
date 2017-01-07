<?php

namespace App\Http\Controllers\AreaAdmin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
    	return view('area-admin.index');
    }
}
