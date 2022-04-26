@extends('layouts.main')
@section('title', 'Create a Recipe')
@section('content')
<form method="POST" action="{{ route('recipe.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="recipe_name" class="form-label">Recipe Name</label>
        <input type="text" id="recipe_name" class="form-control" name="recipe_name" value="{{ old('recipe_name') }}">
        @error('recipe_name')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="mb-3">
        <label for="cuisine" class="form-label">Cuisine</label>
        <select name="cuisine" id="cuisine" class="form-select">
            <option value="">-- Select Cuisine --</option>
            @foreach($cuisines as $cuisine)
            <option value="{{$cuisine->id}}" {{ (string) $cuisine->id ===  (string) old('cuisine') ? 'selected' : ''}}>
                {{$cuisine->cuisine_name}}
            </option>
            @endforeach
    
        </select>
        @error('cuisine')
        <small class="text-danger">{{$message}}</small>
        @enderror
    
    </div>
    <div class="mb-3">
        <label for="type" class="form-label">Type</label>
        <select name="type" id="type" class="form-select">
            <option value="">-- Select Type --</option>
            @foreach($types as $type)
            <option value="{{$type->id}}" {{ (string) $type->id ===  (string) old('type') ? 'selected' : ''}}>
                {{$type->type_name}}
            </option>
            @endforeach
    
        </select>
        @error('type')
        <small class="text-danger">{{$message}}</small>
        @enderror
    
    </div>
    <div class="mb-3">
        <label for="serving" class="form-label">Serving(s):</label>
        <input type="number" id="serving" class="form-control" name="serving" value="{{ old('serving') }}">
        @error('serving')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="mb-3">
        <label for="cooking_time" class="form-label">Cooking Time (Minutes):</label>
        <input type="number" id="cooking_time" class="form-control" name="cooking_time" value="{{ old('cooking_time') }}">
        @error('cooking_time')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="mb-3">
        <label for="ingredients" class="form-label">Ingredients:</label>
        <textarea id="ingredients" class="form-control" name="ingredients">{{ old('ingredients') }}</textarea>
        @error('ingredients')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="mb-3">
        <label for="directions" class="form-label">Directions:</label>
        <textarea id="directions" class="form-control" name="directions">{{ old('directions') }}</textarea>
        @error('directions')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="mb-3">
        <label for="notes" class="form-label">Notes (Optional):</label>
        <textarea id="notes" class="form-control" name="notes">{{ old('notes') }}</textarea>
        @error('notes')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="images mb-3">
        <label for="images" class="form-label">Add Image(s):</label>
        <input type="file" class="form-control" name="images[]" id="images" multiple >
        @error('images')
        <small class="text-danger">{{$message}}</small>
        @enderror
        @error('images.*')
        <small class="text-danger">{{$message}}</small>
        @enderror
      </div>
    <button type="submit" class="btn btn-success">Create</button>
</form>
@endsection