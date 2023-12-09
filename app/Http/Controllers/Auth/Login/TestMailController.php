<?php

namespace App\Http\Controllers\Auth\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Mail\SendMail;


class TestMailController extends Controller
{
    public function send(){
        return Mail::to('s.nacchi0609@gmail.com')->send(new SendMail());
    }

}
