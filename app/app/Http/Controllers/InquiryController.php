<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InquiryController extends Controller
{
    // 問い合わせ入力
    public function form($property)
    {
        return view('inquiry.form', ['property_id' => $property]);
    }

    // 確認
    public function confirm(Request $request)
    {
        return view('inquiry.confirm');
    }

    // 完了
    public function complete(Request $request)
    {
        return view('inquiry.complete');
    }
}
