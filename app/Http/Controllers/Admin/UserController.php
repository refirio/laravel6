<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserPost;

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
        return view('admin.user.create');
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

        return redirect('/admin/user');
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

        return redirect('/admin/user');
    }
}
