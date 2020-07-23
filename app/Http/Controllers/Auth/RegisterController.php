<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Services\UserService;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/mypage';

    /**
     * Create a new controller instance.
     *
     * @param  UserService  $userService
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('guest');

        $this->userService = $userService;
    }

    /**
     * Confirm a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    protected function confirm(StoreUserRequest $request)
    {
        $post = $request->all();
        $request->session()->put('post.register', $post);

        return view('auth.confirm', [
            'user' => $post,
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        if (!$request->session()->has('post.register')) {
            return redirect()->route('register');
        }

        $post = $request->session()->get('post.register');

        $postRequest = new StoreUserRequest();
        $postRequest->merge($post);

        $request->session()->forget('post.register');

        event(new Registered($user = $this->userService->storeUser($postRequest)));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }
}
