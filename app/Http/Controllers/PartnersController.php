<?php

namespace App\Http\Controllers;

use App\PartnersClientPay;
use Illuminate\Http\Request;

class PartnersController extends Controller
{
    public function index(){


$partners=auth()->user()->partners;
$summ=PartnersClientPay::where('user_id',auth()->user()->id)->sum('summ');

        return view('setting.partners.index',compact('partners','summ'));
    }
}
