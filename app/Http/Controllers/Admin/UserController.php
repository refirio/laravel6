<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  UserService  $userService
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('auth');

        $this->userService = $userService;
    }

    /**
     * Display a list of all users.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('admin.user.index', [
            'users' => $this->userService->getUsers([], [['id', 'desc']]),
        ]);
    }

    /**
     * Display a form of new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create(Request $request)
    {
        return view('admin.user.form');
    }

    /**
     * Create a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreUserRequest $request)
    {
        if ($this->userService->storeUser($request)) {
            return redirect()->route('admin.user.index')->with('message', 'ユーザを登録しました。');
        } else {
            return redirect()->route('admin.user.index')->with('error', 'ユーザを登録できませんでした。');
        }
    }

    /**
     * Display a form of edit user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        return view('admin.user.form', [
            'user' => $this->userService->getUser($id),
        ]);
    }

    /**
     * Update a user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        if ($this->userService->updateUser($request, $id)) {
            return redirect()->route('admin.user.index')->with('message', 'ユーザを編集しました。');
        } else {
            return redirect()->route('admin.user.index')->with('error', 'ユーザを編集できませんでした。');
        }
    }

    /**
     * Destroy the given user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        if ($this->userService->deleteUser($id)) {
            return redirect()->route('admin.user.index')->with('message', 'ユーザを削除しました。');
        } else {
            return redirect()->route('admin.user.index')->with('error', 'ユーザを削除できませんでした。');
        }
    }
}
