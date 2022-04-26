@extends('layouts.main')
@section('title', Auth::user()->name . '\'s Homepage')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('homepage.index') }}">My Recipes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('homepage.favorite') }}">My Favorites</a>
                    </li>
                </ul>
            </div>
            <div class="col-9">
                <header>
                    <h5>@yield("child-title")</h5>
                </header>
                <main>
                    @yield('child-content')
                </main>
            </div>
        </div>
    </div>
@endsection
