<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
  public function handle() {
    if(Auth::check()) {
      return view('index', ['name' => Auth::user() -> name]);
    }
    return view('index');
  }
}
