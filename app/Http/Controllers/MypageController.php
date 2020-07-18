<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class MypageController extends Controller
{
    /**
     * インスタンス作成
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * マイページ
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('mypage/index');
    }

    /**
     * 基本情報編集画面
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function basis(Request $request)
    {
        // ユーザー情報取得
        $user = Auth::guard()->user();

        return view('mypage/basis', [
            'user' => $user,
        ]);
    }

    /**
     * 基本情報編集
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function basisUpdate (UpdateUserRequest $request)
    {
        // 編集
        $userId = Auth::guard()->user()->id;

        $user = User::find($userId);
        $user->name = $request->name;
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect('mypage/basis')->with('message', '基本情報を編集しました。');
    }
}
