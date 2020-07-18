<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;

class MypageController extends Controller
{
    /**
     * インスタンス作成
     *
     * @param UserService $userService
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
    public function basisUpdate(UpdateUserRequest $request)
    {
        // 編集
        $id = Auth::guard()->user()->id;

        if ($this->userService->updateUser($request, $id)) {
            return redirect()->route('mypage.basis')->with('message', '基本情報を編集しました。');
        } else {
            return redirect()->route('mypage.basis')->with('message', '基本情報を編集できませんでした。');
        }
    }
}
