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
        // 物件情報を渡してフォーム表示
        return view('inquiry.form', compact('property'));
        // もし view 名が inquiries.create の場合は:
        // return view('inquiries.create', compact('property'));
    }

    /**
     * 確認画面
     * POST /inquiries/confirm
     */
    public function confirm(Request $request)
{
    // ✅ ここで「その他」のときだけ message 必須
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
            'message.required_if'   => '「その他のお問い合わせ」を選んだ場合は、詳細内容を入力してください。',
            'name.required'         => 'お名前を入力してください。',
            'email.required'        => 'メールアドレスを入力してください。',
            'email.email'           => '正しいメールアドレスの形式で入力してください。',
        ]
    );

    // ✅ 物件を必ず取って confirm に渡す（ここが “—” の主因）
    $property = \App\Models\Property::query()
        ->select(['id', 'title', 'address', 'rent', 'total', 'businessname'])
        ->findOrFail((int)$validated['property_id']);

    // ✅ confirm で入力保持（入力画面に戻る用に session に入れる）
    $request->session()->put('inquiry_form', $validated);

    return view('inquiry.confirm', compact('property'));
}

public function form($property)
{
    $propertyModel = \App\Models\Property::findOrFail((int)$property);

    // ✅ confirmで保存した入力値を取り出す（無ければ空）
    $form = session('inquiry_form', []);

    return view('inquiry.form', [
        'property' => $propertyModel,
        'form'     => $form,
    ]);
}


    /**
     * 送信（保存）→ 完了画面
     * POST /inquiries
     */
    public function store(Request $request)
    {
        // confirm と同じバリデーション
        $validated = $request->validate(
    [
        'property_id'  => ['required', 'integer', 'exists:properties,id'],
        'inquiry_type' => ['required', 'in:plan,tour,other'],
        'message'      => [
            'nullable',
            'string',
            'max:2000',
            'required_if:inquiry_type,other',
        ],
        'name'  => ['required', 'string', 'max:100'],
        'email' => ['required', 'email', 'max:255'],
        'tel'   => ['nullable', 'string', 'max:30'],
    ],
    [
        // inquiry_type
        'inquiry_type.required' => 'お問い合わせ内容を選択してください。',

        // message
        'message.required_if' => '「その他のお問い合わせ」を選んだ場合は、詳細内容を入力してください。',
        'message.max'         => '詳細内容は2000文字以内で入力してください。',

        // name
        'name.required' => 'お名前を入力してください。',
        'name.max'      => 'お名前は100文字以内で入力してください。',

        // email
        'email.required' => 'メールアドレスを入力してください。',
        'email.email'    => '正しいメールアドレスの形式で入力してください。',

        // tel
        'tel.max' => '電話番号は30文字以内で入力してください。',
    ]
);



        // ここでDB保存する場合（inquiriesテーブルがある想定）
        // ないならこのブロックはコメントアウトしてOK
        // \App\Models\Inquiry::create([
        //     'property_id' => $validated['property_id'],
        //     'name'        => $validated['name'],
        //     'email'       => $validated['email'],
        //     'tel'         => $validated['tel'] ?? null,
        //     'message'     => $validated['message'],
        // ]);

        // 完了画面へ
        return view('inquiry.complete', [
            'input' => $validated,
        ]);
    }
}
