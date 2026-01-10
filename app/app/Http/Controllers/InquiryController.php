<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * お問い合わせ入力画面
     * GET /inquiries/{property}
     */
    public function create(Property $property)
    {
        // confirm で保存した入力値（戻る時に復元する用）
        $form = session('inquiry_form', []);

        return view('inquiry.form', compact('property', 'form'));
    }

    /**
     * 確認画面
     * POST /inquiries/confirm
     */
    public function confirm(Request $request)
    {
        // ✅ 「その他」のときだけ message 必須（required_if）
        $validated = $request->validate(
            [
                'property_id'  => ['required', 'integer', 'exists:properties,id'],
                'inquiry_type' => ['required', 'in:plan,tour,other'],
                'message'      => ['nullable', 'string', 'max:2000', 'required_if:inquiry_type,other'],
                'name'         => ['required', 'string', 'max:100'],
                'email'        => ['required', 'email', 'max:255'],
                'tel'          => ['nullable', 'string', 'max:30'],
            ],
            [
                'property_id.required'  => '物件情報が取得できませんでした。',
                'property_id.exists'    => '物件情報が正しくありません。',

                'inquiry_type.required' => 'お問い合わせ内容を選択してください。',
                'inquiry_type.in'       => 'お問い合わせ内容が不正です。',

                'message.required_if'   => '「その他のお問い合わせ」を選んだ場合は、詳細内容を入力してください。',
                'message.max'           => '詳細内容は2000文字以内で入力してください。',

                'name.required'         => 'お名前を入力してください。',
                'name.max'              => 'お名前は100文字以内で入力してください。',

                'email.required'        => 'メールアドレスを入力してください。',
                'email.email'           => '正しいメールアドレスの形式で入力してください。',
                'email.max'             => 'メールアドレスは255文字以内で入力してください。',

                'tel.max'               => '電話番号は30文字以内で入力してください。',
            ]
        );

        // ✅ 物件情報を必ずDBから取得して confirm に渡す
        $property = Property::query()
            ->select(['id', 'title', 'address', 'rent', 'businessname', 'nearest_station', 'walk_minutes'])
            ->findOrFail((int)$validated['property_id']);

        // ✅ 入力保持（確認画面→入力へ戻るため）
        $request->session()->put('inquiry_form', $validated);

        return view('inquiry.confirm', [
            'property' => $property,
            'input'    => $validated,
        ]);
    }

    /**
     * 送信（保存）→ 完了画面
     * POST /inquiries（または /inquiries/complete にしてもOK）
     */
    public function store(Request $request)
    {
        // ✅ confirm で session に入れた内容を基本にする（hidden改ざん対策にもなる）
        $data = session('inquiry_form');

        // セッションが無い・期限切れなら入力へ戻す（419回避にもなる）
        if (!$data || empty($data['property_id'])) {
            return redirect()->route('top')
                ->with('error', 'セッションが切れました。もう一度入力してください。');
        }

        // 念のためバリデーション（confirm と同条件）
        $validated = validator($data, [
            'property_id'  => ['required', 'integer', 'exists:properties,id'],
            'inquiry_type' => ['required', 'in:plan,tour,other'],
            'message'      => ['nullable', 'string', 'max:2000', 'required_if:inquiry_type,other'],
            'name'         => ['required', 'string', 'max:100'],
            'email'        => ['required', 'email', 'max:255'],
            'tel'          => ['nullable', 'string', 'max:30'],
        ])->validate();

        // ✅ ここで保存（inquiriesテーブルがある場合）
        // ないならこのブロックはコメントアウトでOK
        // \App\Models\Inquiry::create([
        //     'property_id'  => $validated['property_id'],
        //     'inquiry_type' => $validated['inquiry_type'],
        //     'message'      => $validated['message'] ?? null,
        //     'name'         => $validated['name'],
        //     'email'        => $validated['email'],
        //     'tel'          => $validated['tel'] ?? null,
        // ]);

        // ✅ 完了後はフォーム保持セッションを消す
        $request->session()->forget('inquiry_form');

        $property = Property::query()
            ->select(['id', 'title'])
            ->findOrFail((int)$validated['property_id']);

        return view('inquiry.complete', [
            'property' => $property,
            'input'    => $validated,
        ]);
    }
}
