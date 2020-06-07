<?php

namespace App\Http\Controllers;

class FavoriteController extends Controller
{
    /**
     * @param int $micropostId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($micropostId)
    {
        \Auth::user()->favorite($micropostId);
        return back()->with([
            'message' => 'お気に入りに追加しました。',
        ]);
    }

    /**
     * @param int $micropostId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($micropostId)
    {
        \Auth::user()->unFavorite($micropostId);
        return back()->with([
            'message' => 'お気に入りから削除しました。',
        ]);
    }
}
