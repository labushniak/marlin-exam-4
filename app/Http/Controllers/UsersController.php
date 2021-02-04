<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UsersInfo;
use App\Models\UsersLinks;
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
        
        //добавляю пользователя в таблицу users, users_info, users_links
        $newUser = User::create(['email' => $this->request->email, 'password' => Hash::make($this->request->password)]);
        UsersInfo::create(['user_id' => $newUser->id, 'job_title' => '', 'phone' => '', 'address' => '']);
        UsersLinks::create(['user_id' => $newUser->id, 'vk' => '', 'telegram' => '', 'instagram' => '']);
        
        //статус - пользователь зарегистрирован
        session(['status' => 'New user registered!']);
        
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

        $current_user_id = Auth::id();

        return view('users', ['status' => $status, 'users' => $users, 'user_statuses' => $user_statuses, 'current_user_id' => $current_user_id]);
    }


    public function showProfile($id = null)
    {
        if (!$id){
            return redirect()->route('home');    
        }

        $userById = DB::table('users')
        ->join('users_info', function ($join) {
            $join->on('users.id', '=', 'users_info.user_id');
        })
        ->join('users_links', function ($join) {
            $join->on('users.id', '=', 'users_links.user_id');
        })
        ->where('users.id', $id)
        ->get();
        
        if ($userById->first()) {
            return view('profile', ['user' => $userById->first()]);
        }

        session(['status' => 'User ID does not exist']);

        return redirect()->route('home');
        
    }

    public function createShowForm()
    {    
        return view('create');
    }

    public function createPostHandler()
    {
        //валидация данных формы
        $this->request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email:rfc|unique:users|min:6',
            'password' => 'required|min:6|max:25',
            'job_title' => 'required|min:3',
            'phone' => 'required|min:6',
            'address' => 'required|min:6',
            'avatar' => 'required|image',
            'vk' => 'required|min:3',
            'telegram' => 'required|min:3',
            'instagram' => 'required|min:3'
        ]);
        
        //добавляю пользователя в таблицу users, users_info, users_links
        $newUser = User::create([
                'name' => $this->request->name,
                'email' => $this->request->email, 
                'password' => Hash::make($this->request->password)
            ]);

        UsersInfo::create([
            'user_id' => $newUser->id, 
            'job_title' => $this->request->job_title, 
            'phone' => $this->request->phone, 
            'address' => $this->request->address,
            'avatar' => $this->request->file('avatar')->store('uploads')
        ]);

        UsersLinks::create([
            'user_id' => $newUser->id, 
            'vk' => $this->request->vk, 
            'telegram' => $this->request->telegram, 
            'instagram' => $this->request->instagram
        ]);
        
        //статус - пользователь зарегистрирован
        session(['status' => 'New user registered!']);
        
        return redirect()->route('home');
    }

    public function editShowForm($id = null)
    {
        //проверяем существование id
        if (!$id){
            session(['status' => 'User ID does not exist!']);
            return redirect()->route('home');
        }

        //получаем данные пользователя для вывода в форме
        $userById = DB::table('users')
        ->join('users_info', function ($join) {
            $join->on('users.id', '=', 'users_info.user_id');
        })
        ->where('users.id', $id)
        ->get();

        //проверяем, редактирует пользователь свой профиль или это делает админ
        if (!(auth()->user()->id == $userById->first()->user_id || (auth()->check() && auth()->user()->is_admin == 1))){
            session(['status' => 'You do not have permission to edit user profile']);
            return redirect()->route('home');
        }
        
        

        if ($userById->first()) {
            
            return view('edit', ['user' => $userById->first()]);
        } 

        session(['status' => 'User ID does not exist']);
        return redirect()->route('home');
    }


    public function editPostHandler($id)
    {
        //валидация данных формы
        $this->request->validate([
            'name' => 'required|min:2',
            'job_title' => 'required|min:3',
            'phone' => 'required|min:6',
            'address' => 'required|min:6',
        ]);
        
        DB::table('users')
              ->where('id', $id)
              ->update(['name' => $this->request->name]);

        DB::table('users_info')
              ->where('user_id', $id)
              ->update([
                  'job_title' => $this->request->job_title,
                  'phone' => $this->request->phone,
                  'address' => $this->request->address,
                ]);
        
        session(['status' => 'User data updated successfully!']);
        return redirect()->route('home');
        
    }

    public function securityShowForm($id = null)
    {
        //проверяем существование id
        if (!$id){
            session(['status' => 'User ID does not exist!']);
            return redirect()->route('home');
        }

        //получаем данные пользователя для вывода в форме
        $userById = DB::table('users')->where('id', $id)->get();

        //проверяем, редактирует пользователь свой профиль или это делает админ
        if (!(auth()->user()->id == $userById->first()->id || (auth()->check() && auth()->user()->is_admin == 1))){
            session(['status' => 'You do not have permission to edit user profile']);
            return redirect()->route('home');
        }
        
        $userById = DB::table('users')->where('id', $id);
        
        if($userById->first()){
            return view('security', ['user' => $userById->first()]);
        }

        session(['status' => 'User ID does not exist']);
        return redirect()->route('home');
    }

    public function securityPostHandler($id = null)
    {
        //проверяем существование id
        if (!$id){
            session(['status' => 'User ID does not exist!']);
            return redirect()->route('home');
        }
        
        //берем существующий email
        $old_email = DB::table('users')->where('id', $id)->first()->email;

        if($old_email != $this->request->email){//сравниваем email из формы и email в базе
            //валидация данных формы если email был измененн
            $this->request->validate([
                'email' => 'required|email:rfc|unique:users|min:6',
                'password' => 'required|min:6|max:25',
                'password_again' => 'required|same:password'
            ]);    
        }else{
            //валидация данных формы если email не был измененн
            $this->request->validate([
                'email' => 'required|email:rfc|min:6',
                'password' => 'required|min:6|max:25',
                'password_again' => 'required|same:password'
            ]);    
        }

        //обновляем данные пользователя
        $result = DB::table('users')
              ->where('id', $id)
              ->updateOrInsert(['email' => $this->request->email, 'password' => Hash::make($this->request->password)]);

        //если обновление прошло успешно, то выводим статус
        if($result){
            session(['status' => 'Security data updated successfully!']);
            return redirect()->route('home');
        }

    }

    public function statusShowForm($id = null)
    {
       //проверяем существование id
        if (!$id){
            session(['status' => 'User ID does not exist!']);
            return redirect()->route('home');
        }

        //получаем данные пользователя для вывода в форме
        $userById = DB::table('users')->where('id', $id)->get();

        //проверяем, редактирует пользователь свой профиль или это делает админ
        if (!(auth()->user()->id == $userById->first()->id || (auth()->check() && auth()->user()->is_admin == 1))){
            session(['status' => 'You do not have permission to edit user profile']);
            return redirect()->route('home');
        }

        $user = DB::table('users_info')->where('user_id', $id)->first();
        
        $statuses = [
            'online' => 'Онлайн',
            'dont_disturb' => 'Не беспокоить',
            'out' => 'Отошел'
        ];

        return view('status', ['user' => $user, 'statuses' => $statuses]);
    }

    public function statusPostHandler($id = null)
    {
        //проверяем существование id
        if (!$id){
            session(['status' => 'User ID does not exist!']);
            return redirect()->route('home');
        }
        
        //обновляем данные пользователя
        $result = DB::table('users_info')
              ->where('user_id', $id)
              ->updateOrInsert(['status' => $this->request->status]);
        
        
        //если обновление прошло успешно, то выводим статус
        if($result){
                session(['status' => 'Status updated successfully!']);
                return redirect()->route('home');
            }
            
    }


    public function avatarShowForm($id = null)
    {
        //проверяем существование id
        if (!$id){
            session(['status' => 'User ID does not exist!']);
            return redirect()->route('home');
        }

        //получаем данные пользователя для вывода в форме
        $userById = DB::table('users')->where('id', $id)->get();

        //проверяем, редактирует пользователь свой профиль или это делает админ
        if (!(auth()->user()->id == $userById->first()->id || (auth()->check() && auth()->user()->is_admin == 1))){
            session(['status' => 'You do not have permission to edit user profile']);
            return redirect()->route('home');
        }
        
        $user = DB::table('users_info')->where('user_id', $id)->first();

        return view('avatar', ['user' => $user]);
    }



    public function avatarPostHandler($id = null)
    {
        //проверяем существование id
        if (!$id){
            session(['status' => 'User ID does not exist!']);
            return redirect()->route('home');
        }
        
        //валидация данных формы
        $this->request->validate([
            'avatar' => 'required|image'
        ]);


        //удаляем старый аватар
        $imageName = DB::table('users_info')
                    ->where('user_id', $id)
                    ->select('*')
                    ->first()
                    ->avatar;

        Storage::delete($imageName);

        //обновляем данные пользователя
        $result = DB::table('users_info')
              ->where('user_id', $id)
              ->update(['avatar' => $this->request->file('avatar')->store('uploads')]);

        if($result){
                session(['status' => 'Avatar updated successfully!']);
                return redirect()->route('home');
            }

    }


    public function delete($id = null)
    {
        //проверяем существование id
        if (!$id){
            session(['status' => 'User ID does not exist!']);
            return redirect()->route('home');
        }

        //получаем данные пользователя для вывода в форме
        $userById = DB::table('users')->where('id', $id)->get();

        //проверяем, редактирует пользователь свой профиль или это делает админ
        if (!(auth()->user()->id == $userById->first()->id || (auth()->check() && auth()->user()->is_admin == 1))){
            session(['status' => 'You do not have permission to edit user profile']);
            return redirect()->route('home');
        }
        
        //удаляем аватар
        $imageName = DB::table('users_info')
                    ->where('user_id', $id)
                    ->select('*')
                    ->first()
                    ->avatar;

        Storage::delete($imageName);
        
        //удаляем все записи
        DB::table('users')->where('id', $id)->delete();
        DB::table('users_info')->where('user_id', $id)->delete();
        DB::table('users_links')->where('user_id', $id)->delete();

        //удаление сессий

        if(!auth()->user()->is_admin == 1){
            $this->request->session()->invalidate();
            $this->request->session()->regenerateToken();
        }

        session(['status' => 'User deleted!']);
        return redirect()->route('home');

    }
   
}
