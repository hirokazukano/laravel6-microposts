<?php

namespace App\Http\Controllers;

class UserFollowController extends Controller
{
    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($id)
    {
        \Auth::user()->follow($id);
        return back()->with([
            'message' => 'フォローしました。',
        ]);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        \Auth::user()->unFollow($id);
        return back()->with([
            'message' => 'フォローを外しました。',
        ]);
    }
}
