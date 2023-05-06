<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\Sto;
use App\Lib\Tool;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){

        return view('admin.index');
    }

}
