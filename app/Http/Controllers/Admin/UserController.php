<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserPost;
use App\Http\Requests\UpdateUserPost;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
            'users' => User::orderBy('created_at', 'asc')->get()
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
    public function store(StoreUserPost $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.user.index')->with('message', '登録しました。');
    }

    /**
     * Display a form of edit user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $user = User::find($id);

        return view('admin.user.form', [
            'user' => $user,
        ]);
    }

    /**
     * Update a user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(UpdateUserPost $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('admin.user.index')->with('message', '編集しました。');
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
        User::findOrFail($id)->delete();

        return redirect()->route('admin.user.index')->with('message', '削除しました。');
    }
}
