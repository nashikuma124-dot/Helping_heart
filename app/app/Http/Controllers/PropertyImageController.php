<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;

class PropertyImageController extends Controller
{
    /**
     * 物件画像アップロード
     * POST /properties/{property}/images
     */
    public function store(Request $request, Property $property)
    {
        $validated = $request->validate(
            [
                'image'      => ['required', 'file', 'image', 'max:5120'], // 5MB
                'sort_order' => ['nullable', 'integer', 'min:0'],
            ],
            [
                'image.required' => '画像を選択してください。',
                'image.image'    => '画像ファイルを選択してください。',
                'image.max'      => '画像サイズは5MB以内にしてください。',
            ]
        );

        $path = $request->file('image')->store("properties/{$property->id}", 'public');

        $sortOrder = array_key_exists('sort_order', $validated)
            ? (int)$validated['sort_order']
            : ((int) PropertyImage::where('property_id', $property->id)->max('sort_order') + 1);

        PropertyImage::create([
            'property_id' => $property->id,
            'image_path'  => $path,
            'sort_order'  => $sortOrder,
        ]);

        return back()->with('success', '画像を追加しました。');
    }
}
