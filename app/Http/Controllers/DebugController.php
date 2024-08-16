<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebugController extends Controller
{
    public function __construct() {}

    public function index() : void
    {
      echo "is test";
    }
}
