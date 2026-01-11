<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // お気に入り一覧
    public function index()
    {
        $user = auth()->user();

        $properties = $user->favoriteProperties()
            ->with(['images', 'area', 'gender', 'cities'])
            ->latest('properties.id')
            ->paginate(10);

        return view('favorites.index', compact('properties'));
    }

    // お気に入り登録（AJAX）
    public function store(Request $request, Property $property)
    {
        $user = $request->user();

        $already = $user->favoriteProperties()
            ->where('properties.id', $property->id)
            ->exists();

        if (!$already) {
            $user->favoriteProperties()->syncWithoutDetaching([$property->id]);
        }

        // AJAXならJSON
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'ok'        => true,
                'favorited' => true,
                'message'   => $already ? 'お気に入り登録済みです。' : 'お気に入りに登録されました',
            ]);
        }

        // 通常アクセスなら戻す
        return back()->with('success', $already ? 'お気に入り登録済みです。' : 'お気に入りに登録されました');
    }

    // ✅ お気に入り解除（DELETE）
    public function destroy(Request $request, Property $property)
    {
        $user = $request->user();

        // pivot削除
        $user->favoriteProperties()->detach($property->id);

        // AJAXならJSON
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'ok'        => true,
                'favorited' => false,
                'message'   => 'お気に入りを解除しました',
            ]);
        }

        return back()->with('success', 'お気に入りを解除しました');
    }
}
