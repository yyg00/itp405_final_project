@extends('homepage.main')
@section('child-title', Auth::user()->name . '\'s Favorites')
@section('child-content')
    <div>
        @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
        @if(count($fav_recipes) != 0)
        @foreach($fav_recipes as $fav)
            @canany(['view', 'delete'], $fav)
            <div class="container mb-1" style="width:400px; margin-left:0;">
                <div class="row">
                    <div class="col-1 align-items-center">
                        <form method="post" action={{route('favorite.delete', ['id' => $fav->id])}} class="text-center"> 
                            @csrf
                            <button type="submit" class="btn btn-light" style="background: none; padding: 0px; border: none;">
                                <i class="bi bi-bookmark-heart-fill text-danger"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-11">
                    <div><a href={{route('recipe.show', ['id' => $fav->recipe->id])}}>{{$fav->recipe->recipe_name}}</a></div>
                    <div>Saved at: {{date_format($fav->created_at, 'm/d/Y H:i')}}</div>
                    </div>
                </div>
            </div>
            @endcanany
        @endforeach
        @else
        <div>
            You haven't added anything to your favroites.
        </div>
        @endif
    </div>
@endsection