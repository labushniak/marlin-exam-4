<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        
    }

    public function registrationShowForm()
    {
        return view('register');
    }

    public function registrationPostHandler()
    {
        //валидация почты и пароля
        $this->validate($this->request, [
            'email' => 'required|email:rfc|unique:users|min:6',
            'password' => 'required|min:6|max:25'
        ]);
        
        //добавляю в таблицу users email и hash пароля
        User::create(['email' => $this->request->email, 'password' => Hash::make($this->request->password)]);

        //статус - пользователь зарегистрирован
        session(['status' => 'New user registered!']);

        return redirect()->route('login');
    }

    public function loginShowForm()
    {
        //сохраняю данные сессии
        $status = session('status');

        //удаляю сессию
        session()->forget('status');

        return view('login', ['status' => $status]);
    }

    public function loginPostHandler()
    {
        $credentials = $this->request->only('email', 'password');

        if(Auth::attempt($credentials, $this->request->remember)){
            session()->regenerate();
            session(['status' => 'User logged in successfully!']);
            return redirect()->route('home');

        }

        //return back();
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
            
            ]);
    }

    public function home()
    {

        //сохраняю данные сессии
        $status = session('status');

        //удаляю сессию
        session()->forget('status');

        return view('users', ['status' => $status]);
    }
    
}
