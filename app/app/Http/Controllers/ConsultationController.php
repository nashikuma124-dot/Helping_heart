<?php

namespace App\Http\Controllers;

class ConsultationController extends Controller
{
    // 相談トップ
    public function index()
    {
        return view('consultation.index');
    }

    // グループホーム LINE
    public function homeLine()
    {
        return view('consultation.home_line');
    }

    // グループホーム チャット
    public function homeChat()
    {
        return view('consultation.home_chat');
    }

    // 福祉サービス LINE
    public function welfareLine()
    {
        return view('consultation.welfare_line');
    }

    // 福祉サービス チャット
    public function welfareChat()
    {
        return view('consultation.welfare_chat');
    }

    // 管理者用 相談一覧（仮）
    public function adminIndex()
    {
        return view('admin.dashboard');
    }
}
