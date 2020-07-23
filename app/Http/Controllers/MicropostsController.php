<?php

namespace App\Http\Controllers;

use App\Micropost;
use Illuminate\Http\Request;

class MicropostsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $microposts = $user->feed_microposts()
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $data = [
                'user' => $user,
                'microposts' => $microposts,
            ];
        }

        return view('welcome', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:255',
        ]);
        $user = $request->user();
        $user->microposts()->create([
            'content' => $request->input('content'),
        ]);

        return back()->with([
            'message' => '投稿しました。',
        ]);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $micropost = Micropost::findOrFail($id);
        if (\Auth::id() === $micropost->user_id) {
            $micropost->delete();
        }

        return back()->with([
            'message' => '削除しました。',
        ]);
    }

    /**
     * エラー通知確認
     */
    public function sendSlack()
    {
        $array = [];
        echo $array['hoge'];
    }
}
