@extends('layouts.base')
@section('content')
    <div class="page-container">
        @include('layouts.header')
        <div class="main-content">
            <div class="header-area">
                <div class="row align-items-center">
                    <div class="col-6 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="col-6 clearfix">
                        <div class="user-profile pull-right">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->USER_USUARIO }} <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content-inner mt-3">
                @yield('page-content')
            </div>
        </div>
    </div>
@endsection