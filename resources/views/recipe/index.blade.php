@extends('layouts.main')
@section('title', 'Recipes')
@section('content')
@if (session('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif
@if(count($recipes) != 0)
<div class="container-fluid">

@php($cnt = 0)
<div class="container mx-auto">
@foreach($recipes as $recipe)
@if($cnt % 4 == 0)

    <div class="row mx-auto">
@endif
        <div class="card mb-3 col-xs-4" style="margin-right: 10px; width: 18rem;">
            <img src="{{  Storage::disk('s3')->url($recipe->url) }}" class="card-img-top" style="width:auto; height:200px; object-fit: cover;" alt="{{ $recipe->recipe_name }}">

            <div class="card-body">
            <h6 class="card-title">{{ $recipe->recipe_name }} </h6>
            <div class="d-flex justify-content-between">
            <span class="card-text" style="font-size:13px;">{{$recipe->user_id ? $recipe->user->name : 'Guest'}}</span>
            <i class="bi bi-heart-fill" style="color:red; font-size:13px;"> {{$recipe->fav_cnt ? $recipe->fav_cnt : 0}}</i>
            </div>
            <hr style=""/>
            <div class="text-center">
                <a href="{{route('recipe.show', ['id' => $recipe->id])}}" class="stretched-link" style="text-decoration: none; font-size: 14px;">Read More</a>
            </div>
            @if(Auth::check())
                @canany(['update', 'delete'], $recipe)
                <div class="btn-group" style="z-index: 99; position: absolute; top:0; right:0; ">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-list"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('recipe.edit', ['id' => $recipe->id]) }}">Edit</a></li>
                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteRecipeModal_{{$recipe->id}}"
                            data-action="{{ route('recipe.delete', ['id' => $recipe->id]) }}">Delete</a>
                        </li>
                    </ul>
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
                @endcanany
            @endif
            </div>
        </div>
@if($cnt % 4 == 3)
    </div>

@endif
@php($cnt+=1)
@endforeach
</div>
</div>
@else
    <div>Nothing yet. 
        <a href="{{route('recipe.create')}}">Create a recipe now</a>
    </div>
@endif
@endsection