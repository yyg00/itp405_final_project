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
            <a data-bs-toggle="modal" data-bs-target="#deleteRecipeModal_{{$recipe->id}}"
                data-action="{{ route('recipe.delete', ['id' => $recipe->id]) }}"> <i class="bi bi-trash text-danger"></i></a>
        </div>
        <div class="modal fade" id="deleteRecipeModal_{{$recipe->id}}" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="deleteRecipeModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="deleteRecipeModalLabel">Confirm deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form method="post" action="{{ route('recipe.delete', ['id' => $recipe->id]) }}">
                    <div class="modal-body">
                      @csrf
                      <p class="text-center">Are you sure you want to delete <i>{{$recipe->recipe_name}}?</i></p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </form>
                </div>
              </div>
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