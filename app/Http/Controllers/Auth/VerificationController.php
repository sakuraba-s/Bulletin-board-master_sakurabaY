<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerificationController extends Controller
{

        /**
     * 確認メール送信画面
     */
    public function show()
    {
    return view('auth.verify');
    }

    /**
     * 確認メール送信
     */
    public function send()
    {}

    /**
     * メールリンクの検証
     */
    public function verify()
    {}

}
