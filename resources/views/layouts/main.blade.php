<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
    <title>@yield("title") - Cookbook App</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    {{-- <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script> --}}
    <style>
      body {
        font-family: 'Roboto Condensed';
      }
    </style>

  </head>
<body>
    <div class="container mt-3 mb-3">
        <div class="row">
            <div class="mt-2">
                <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
                  <div class="container-fluid">
                    <a class="navbar-brand" href="{{route('recipe.index')}}">Recipes</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                          <a class="nav-link" aria-current="page" href="{{route('recipe.create')}}">Create New Recipe</a>
                        </li>
                        @if(Auth::check())
                        <li class="nav-item">
                          <a class="nav-link" href="{{ route('homepage.index') }}">Homepage</a>
                        </li>
                        <li class="nav-item">
                          <form method="post" action="{{ route('auth.logout')}}">
                           @csrf
                           <button type="submit" class="btn nav-link">Logout</button>
                       </form>
                       </li>
                        @else
                        <li class="nav-item">
                          <a class="nav-link" href="{{ route('registration.index') }}">Register</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        @endif
                      </ul>
                    </div>
                  </div>
                </nav>
              <hr />
            </div>
            <div>
                @if (session('error'))
                  <div class="alert alert-danger">
                      
                      {{ session('error') }}
                  </div>
                @endif
                <main>
                    @yield("content")
                </main>
            </div>
        </div>
    </div>
</body>
</html>
