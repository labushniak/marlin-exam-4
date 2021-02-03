<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    private $request;

    public function __construct(Request $request, User $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    public function registrationShowForm()
    {
        return view('register');
    }

    public function registrationPostHandler()
    {
        //валидация почты и пароля
        $this->request->validate([
            'email' => 'required|email:rfc|unique:users|min:6',
            'password' => 'required|min:6|max:25'
        ]);
        
        //добавляю в таблицу users email и hash пароля
        User::create(['email' => $this->request->email, 'password' => Hash::make($this->request->password)]);

        //статус - пользователь зарегистрирован
        $this->request->session(['status' => 'New user registered!']);

        return redirect()->route('login');
    }

    public function loginShowForm()
    {
        //сохраняю данные flash-сообщения
        $status = session('status');

        //удаляю куки с флеш-сообщением
        session()->forget('status');

        return view('login', ['status' => $status]);
    }

    public function loginPostHandler()
    {
        $this->request->validate([
            'email' => 'required|email:rfc',
            'password' => 'required'
        ]);
        
        $credentials = $this->request->only('email', 'password');

        if($this->request->remember == "on"){
            $is_remembered = true;
        } else {
            $is_remembered = false;
        }

        if(Auth::attempt($credentials, $is_remembered)){
            $this->request->session()->regenerate();
            $this->request->session(['status' => 'User logged in successfully!']);
            return redirect()->route('home');

        }

        return redirect()->back()->withErrors([
            'email' => 'Email or password are invalid.',
            ]);
    }

    public function logout()
    {
        Auth::logout();

        $this->request->session()->invalidate();

        $this->request->session()->regenerateToken();

        return redirect()->route('home');

    }

    public function home()
    {

        //обработка flash-сообщений
        //сохраняю данные сессии
        $status = session('status');
        session()->forget('status');

        //вывод пользователей из БД с пагинатором
        $users = DB::table('users')
            ->join('users_info', 'users.id', '=', 'users_info.user_id')
            ->join('users_links', 'users.id', '=', 'users_links.user_id')
            ->paginate(6);

        $user_statuses = [
            'online' => 'Онлайн',
            'dont_disturb' => 'Не беспокоить',
            'out' => 'Отошел'
        ];

        return view('users', ['status' => $status, 'users' => $users, 'user_statuses' => $user_statuses]);
    }

    public function test()
    {
        \App\Models\UsersInfo::factory()->count(5)->create();
    }
    
}
