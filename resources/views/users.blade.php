@extends('layout')

@section('title')
    Users List
@endsection

@section('styles')
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
    <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-solid.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-regular.css">
@endsection

@section('content')
<nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-primary-gradient">
            <a class="navbar-brand d-flex align-items-center fw-500" href="{{ route('home') }}"><img alt="logo" class="d-inline-block align-top mr-2" src="/img/logo.png"> Учебный проект</a> <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarColor02" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarColor02">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('home') }}">Главная <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">

                @if(auth()->check())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile', ['id' => auth()->user()->id]) }}">Вы вошли как {{ auth()->user()->name }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">Выйти</a>
                </li>

                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Войти</a>
                    </li>
                @endif
                    
                </ul>
            </div>
        </nav>

        <main id="js-page-content" role="main" class="page-content mt-3">
                @if($status)
                    <div class="alert alert-success">
                        {{ $status }}
                    </div>
                @endif
            <div class="subheader">
                <h1 class="subheader-title">
                    <i class='subheader-icon fal fa-users'></i> Список пользователей
                </h1>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    @if(auth()->check() && auth()->user()->is_admin)
                        <a class="btn btn-success" href="{{route('create.form')}}">Добавить</a>
                    @endif

                    <div class="border-faded bg-faded p-3 mb-g d-flex mt-3">
                        <input type="text" id="js-filter-contacts" name="filter-contacts" class="form-control shadow-inset-2 form-control-lg" placeholder="Найти пользователя">
                        <div class="btn-group btn-group-lg btn-group-toggle hidden-lg-down ml-3" data-toggle="buttons">
                            <label class="btn btn-default active">
                                <input type="radio" name="contactview" id="grid" checked="" value="grid"><i class="fas fa-table"></i>
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="contactview" id="table" value="table"><i class="fas fa-th-list"></i>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="js-contacts">
            @foreach($users as $user)
                <div class="col-xl-4">
                    <div id="c_1" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="{{ Str::of($user->name)->lower() }}">
                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                            <div class="d-flex flex-row align-items-center">
                            @switch($user->status)
                                @case('online')
                                <span class="status status-success mr-3">
                                @break

                                @case('dont_disturb')
                                <span class="status status-warning mr-3">
                                @break

                                @case('out')
                                <span class="status status-danger mr-3">
                                @break
                            @endswitch
                                    <span class="rounded-circle profile-image d-block " style="background-image:url(' {{ $user->avatar }}'); background-size: cover;"></span>
                                </span>
                                <div class="info-card-text flex-1">
                                    
                                        <a href="{{ route ('profile', ['id' => $user->user_id]) }}" class="fs-xl text-truncate text-truncate-lg text-info">{{ $user->name }}</a><a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">
                                        @if($current_user_id == $user->user_id || (auth()->check() && auth()->user()->is_admin == 1))
                                        <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>
                                        <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>
                                        @endif
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route ('edit.form', ['id' => $user->user_id]) }}">
                                            <i class="fa fa-edit"></i>
                                        Редактировать</a>
                                        <a class="dropdown-item" href="{{ route ('security.form', ['id' => $user->user_id]) }}">
                                            <i class="fa fa-lock"></i>
                                        Безопасность</a>
                                        <a class="dropdown-item" href="{{ route ('status.form', ['id' => $user->user_id]) }}">
                                            <i class="fa fa-sun"></i>
                                        Установить статус</a>
                                        <a class="dropdown-item" href="{{ route ('avatar.form', ['id' => $user->user_id]) }}">
                                            <i class="fa fa-camera"></i>
                                            Загрузить аватар
                                        </a>
                                        <a href="{{ route ('delete', ['id' => $user->user_id]) }}" class="dropdown-item" onclick="return confirm('are you sure?');">
                                            <i class="fa fa-window-close"></i>
                                            Удалить
                                        </a>
                                    </div>
                                    <span class="text-truncate text-truncate-xl">{{ $user->job_title }}</span>
                                </div>
                                <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_1 > .card-body + .card-body" aria-expanded="false">
                                    <span class="collapsed-hidden">+</span>
                                    <span class="collapsed-reveal">-</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0 collapse show">
                            <div class="p-3">
                            @if($user->phone)
                                <a href="tel:{{ $user->phone }}" class="mt-1 d-block fs-sm fw-400 text-dark">
                                    <i class="fas fa-mobile-alt text-muted mr-2"></i> {{ $user->phone }}</a>
                            @endif
                            @if($user->email)
                                <a href="mailto:{{ $user->email }}" class="mt-1 d-block fs-sm fw-400 text-dark">
                                    <i class="fas fa-mouse-pointer text-muted mr-2"></i> {{ $user->email }}</a>
                            @endif
                            @if($user->address)
                                <address class="fs-sm fw-400 mt-4 text-muted">
                                    <i class="fas fa-map-pin mr-2"></i> {{ $user->address }}</address>
                            @endif
                                <div class="d-flex flex-row">
                                    <a href="https://vk.com/{{ $user->vk }}" class="mr-2 fs-xxl" style="color:#4680C2">
                                        <i class="fab fa-vk"></i>
                                    </a>
                                    <a href="https://telegram.com/{{ $user->telegram }}" class="mr-2 fs-xxl" style="color:#38A1F3">
                                        <i class="fab fa-telegram"></i>
                                    </a>
                                    <a href="https://instagram.com/{{ $user->instagram }}" class="mr-2 fs-xxl" style="color:#E1306C">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            </div>
            {{ $users->links() }}
        </main>
     
        <!-- BEGIN Page Footer -->
        <footer class="page-footer" role="contentinfo">
            <div class="d-flex align-items-center flex-1 text-muted">
                <span class="hidden-md-down fw-700">2021 © Учебный проект</span>
            </div>
            <div>
                <ul class="list-table m-0">
                    <li><a href="{{ route('home') }}" class="text-secondary fw-700">Home</a></li>
                    
                </ul>
            </div>
        </footer>
        
    

    <script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>

        $(document).ready(function()
        {

            $('input[type=radio][name=contactview]').change(function()
                {
                    if (this.value == 'grid')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-g');
                        $('#js-contacts .col-xl-12').removeClassPrefix('col-xl-').addClass('col-xl-4');
                        $('#js-contacts .js-expand-btn').addClass('d-none');
                        $('#js-contacts .card-body + .card-body').addClass('show');

                    }
                    else if (this.value == 'table')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-1');
                        $('#js-contacts .col-xl-4').removeClassPrefix('col-xl-').addClass('col-xl-12');
                        $('#js-contacts .js-expand-btn').removeClass('d-none');
                        $('#js-contacts .card-body + .card-body').removeClass('show');
                    }

                });

                //initialize filter
                initApp.listFilter($('#js-contacts'), $('#js-filter-contacts'));
        });

    </script>
    
@endsection