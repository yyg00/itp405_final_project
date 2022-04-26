@extends('homepage.main')
@section('child-title', $username . '\'s Recipes')
@section('child-content')
@if (session('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif
@if(count($recipes) != 0)

@foreach($recipes as $recipe)
@canany(['update', 'delete'], $recipe)
<div class="container mb-1" style="width:400px; margin-left:0;">
    <div class="row">

        <div class="col-1 align-items-center">
            <a href="{{ route('recipe.edit', ['id' => $recipe->id]) }}" style="font-color:black;">
                <i class="bi bi-pencil-square"></i>
            </a>
        </div>
        <div class="col-1 align-items-center">
            <form method="post" action={{route('recipe.delete', ['id' => $recipe->id])}} class="text-center"> 
                @csrf
                <button type="submit" class="btn btn-light" style="background: none; padding: 0px; border: none;">
                    <i class="bi bi-trash text-danger"></i>
                </button>
            </form>
        </div>
        <div class="col-10">
        <div><a href={{route('recipe.show', ['id' => $recipe->id])}}>{{$recipe->recipe_name}}</a></div>
        <div>Created at: {{date_format($recipe->created_at, 'm/d/Y H:i')}}</div>
        </div>
    </div>
</div>
@endcanany
@endforeach
@else
    <div>Nothing yet. 
        <a href="{{route('recipe.create')}}">Create a Recipe Now.</a>
    </div>
@endif
@endsection