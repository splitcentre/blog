<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TryingController extends Controller
{
    public function boomlan(){
        return view('boom');
    }
    public function g2esport(){
        return view('g2');
    }    public function teamliquid(){
        return view('liquid');
    }    public function bdsesport(){
        return view('bds');
    }    
    public function heroicesport(){
        return view('heroic');
    }
    public function beranda(){
        return view('layout/home');
    }
}
