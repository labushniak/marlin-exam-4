<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        dd(User::count());
    }

    public function registrationShowForm()
    {
        return view('register');
    }

    public function registrationPostHandler()
    {
        //валидация почты и пароля
        $this->validate($this->request, [
            'email' => 'required|email:rfc|unique:users',
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
        
    }
    
}
