<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;

class WebAuthController extends Controller
{
    public function register(Request $request)
    {
        if (Auth::check()) {
            return redirect()
                ->route('profile');
        }
        if ($request->isMethod('post')) {
            $request['login'] = strtolower($request['login']);
            $validated = $request->validate(User::$registerRules);

            $user = new User();
            $user->email = $validated['email'];
            $user->name = $validated['name'];
            $user->login = $validated['login'];
            $user->password = Hash::make($validated['password']);
            $user->save();
            Auth::login($user);
            return redirect()
                ->route('profile');
        }
        return view('register');
    }

    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()
                ->route('profile');
        }
        if ($request->isMethod('post')) {
            $request['login'] = strtolower($request['login']);
            $validated = $request->validate(User::$loginRules);

            if (Auth::attempt($validated)) {
                $request->session()->regenerate();
                return redirect()
                    ->route('profile');
            }
            return view('login', ['errors' => new MessageBag(['Wrong login or password'])]);
        }
        return view('login');
    }

    public function logout(Request $request)
    {
        auth('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    public function profile(Request $request) {
        $user = Auth::user();
        return view('profile', ['user'=>new UserResource($user)]);
    }
}
