<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Type;
use App\Models\Cuisine;
use App\Models\Postimage;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Auth;
use DB;
class RecipeController extends Controller
{
    public function index() {
        $recipes = Recipe::with(['user'])
        ->join(DB::raw('(select recipe_id, min(url) as url from postimages group by recipe_id) images'),
        function($join)
        {
            $join->on('recipes.id', '=', 'images.recipe_id');
        })
        ->leftJoin(DB::raw('(select recipe_id, count(user_id) as fav_cnt from favorites_by_users group by recipe_id) favs'),
        function($join)
        {
            $join->on('recipes.id', '=', 'favs.recipe_id');
        })
        ->orderBy('created_at', 'desc')
        ->get();
        return view('recipe.index', [
            'recipes' => $recipes,
        ]);
    }
    public function show($id) {
        $recipe = Recipe::with(['user', 'cuisine', 'type'])->find($id);
        // $images = Postimage::where('recipe_id', '=', $id)->skip(1)->get();
        $images = $recipe->images()->skip(1)->get();
        // $imageHeader = Postimage::where('recipe_id', '=', $id)->first();
        $imageHeader = $recipe->images()->first();
        $commentController = new CommentController();
        $comments = $commentController->getComments($id);
        $favorited = null;
        if(Auth::check())
        {
            $favorited = Favorite::where([
                'user_id' => Auth::user()->id,
                'recipe_id' => $id,
            ])->first();
        }
        return view('recipe.show', [
            'recipe' => $recipe,
            'images' => $images,
            'imageHeader' =>$imageHeader,
            'comments' => $comments,
            'favorited' => $favorited,
        ]);
    }
    public function create() {
        $types = Type::orderBy('type_name')->get();
        $cuisines = Cuisine::orderBy('cuisine_name')->get();
        return view('recipe.create', [
            'cuisines' => $cuisines,
            'types' => $types,
        ]);
    }
    public function store(Request $request) {
        $request->validate([
            'recipe_name' => 'required|max:30',
            'cuisine' => 'required|exists:cuisines,id',
            'type' => 'required|exists:types,id',
            'serving' => 'required|integer|min:1|max:50',
            'cooking_time' => 'required|integer|min:1|max:1000',
            'ingredients' => 'required|max:255',
            'directions' => 'required|max:512',
            'notes' => 'max:512',
            'images' => 'required',
            'images.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1800,max_height=1800',
        ]);
        $recipe = new Recipe();
        if(Auth::check())
        {
            $recipe->user_id = Auth::user()->id;
        }
        $recipe->recipe_name = $request->input('recipe_name');
        $recipe->cuisine_id = $request->input('cuisine');
        $recipe->type_id = $request->input('type');
        $recipe->serving = $request->input('serving');
        $recipe->cooking_time = $request->input('cooking_time');
        $recipe->ingredients = $request->input('ingredients');
        $recipe->directions = $request->input('directions');
        $recipe->notes = $request->input('notes');
        $recipe->save();
        foreach($request->file('images') as $image) {
            $imageItem = new Postimage();
            // $path = $image->store('public/images', ['disks' => 'images']);
            $path = Storage::disk('s3')->put('images', $image);
            $imageItem->url = $path;
            // $imageItem->url = Storage::disk('s3')->url($path);
            $imageItem->recipe_id = $recipe->id;
            $imageItem->save();
        }
        return redirect()
            ->route('recipe.index')
            ->with('success', "Successfully created {$request->input('recipe_name')}");
    }
    public function edit($id) {

        $types = Type::orderBy('type_name')->get();
        $cuisines = Cuisine::orderBy('cuisine_name')->get();
        $recipe = Recipe::find($id);
        $this->authorize('update', $recipe);
        $images = $recipe->images()->get();
        return view('recipe.edit', [
            'cuisines' => $cuisines,
            'types' => $types,
            'recipe' => $recipe,
            'images' => $images,
        ]);
    }
    public function update(Request $request, $id) {
        $checkbox_cnt = $request->input('prev_images') ? count($request->input('prev_images')) : 0;
        $prev_img_cnt = Postimage::where('recipe_id', $id)->count();

        if ($prev_img_cnt == $checkbox_cnt)
        {
            $request->validate([
                'recipe_name' => 'required|max:30',
                'cuisine' => 'required|exists:cuisines,id',
                'type' => 'required|exists:types,id',
                'serving' => 'required|integer|min:1|max:50',
                'cooking_time' => 'required|integer|min:1|max:1000',
                'ingredients' => 'required|max:255',
                'directions' => 'required|max:512',
                'notes' => 'max:512',
                'images' => 'required',
                'images.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1800,max_height=1800',
            ]);
        }
        else
        {
            $request->validate([
                'recipe_name' => 'required|max:30',
                'cuisine' => 'required|exists:cuisines,id',
                'type' => 'required|exists:types,id',
                'serving' => 'required|integer|min:1|max:50',
                'cooking_time' => 'required|integer|min:1|max:1000',
                'ingredients' => 'required|max:255',
                'directions' => 'required|max:512',
                'notes' => 'max:512',
                'images.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1800,max_height=1800',
            ]);
        }
        $recipe = Recipe::find($id);
        $this->authorize('update', $recipe);
        $recipe->recipe_name = $request->input('recipe_name');
        $recipe->cuisine_id = $request->input('cuisine');
        $recipe->type_id = $request->input('type');
        $recipe->serving = $request->input('serving');
        $recipe->cooking_time = $request->input('cooking_time');
        $recipe->ingredients = $request->input('ingredients');
        $recipe->directions = $request->input('directions');
        $recipe->notes = $request->input('notes');
        $recipe->save();
        if ($checkbox_cnt != 0) 
        {
            foreach($request->input('prev_images') as $id)
            {
                $image = Postimage::find($id);
                // Storage::delete($image->url);
                Storage::disk('s3')->delete($image->url);
                $image->delete();

            }
        }
        if ($request->file('images'))
        {
            foreach($request->file('images') as $image) {
                $imageItem = new Postimage();
                // $path = $image->store('public/images', ['disks' => 'images']);
                $path = Storage::disk('s3')->put('images', $image);
                $imageItem->url = $path;
                $imageItem->recipe_id = $recipe->id;
                $imageItem->save();
            }
        } 
        return redirect()
            ->route('recipe.index')
            ->with('success', "Successfully updated {$request->input('recipe_name')}");
    }
    public function delete(Request $request, $id) {
        $recipe = Recipe::find($id);
        $this->authorize('delete', $recipe);
        $recipe->comments()->delete();
        $recipe->favorites()->delete();
        $images = $recipe->images()->get();
        foreach($images as $image)
        {
            Storage::disk('s3')->delete($image->url);
        }
        $recipe->images()->delete();
        $recipe->delete();
        return redirect()
            ->back()
            ->with('success', "Successfully deleted {$recipe->recipe_name}");

    }
}
