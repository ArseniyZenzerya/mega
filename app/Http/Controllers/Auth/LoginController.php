<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Auth\LoginRequest;
    use App\Http\Requests\Auth\RegisterRequest;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Models\User;
    use Illuminate\Support\Facades\Hash;

    class LoginController extends Controller
    {
        public function showLoginForm()
        {
            return view('auth.login');
        }

        public function login(LoginRequest $request)
        {
            if (Auth::attempt($request->validated())) {
                if (Auth::user()->is_admin) {
                    return redirect()->route('admin.dashboard');
                }

                return redirect()->route('home');
            }

            return back()->withErrors([
                'email' => 'Неверные учетные данные.',
            ]);
        }

        // Логика регистрации
        public function showRegisterForm()
        {
            return view('auth.register');
        }

        public function register(RegisterRequest $request)
        {
            $validated = $request->validated();

            $isFirstUser = User::count() === 0;

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'is_admin' => $isFirstUser,
            ]);

            Auth::login($user);

            return redirect()->route('catalog.index');
        }


        public function logout(Request $request)
        {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/');
        }
    }
