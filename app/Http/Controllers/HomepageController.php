<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Favorite;
use App\Models\Postimage;
use Auth;
class HomepageController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $recipes = Recipe::where('user_id', $id)->get();
        $images = Postimage::all();
        $username = Auth::user()->name;
        return view('homepage.index', [
            'recipes' => $recipes,
            'username' => $username,
            'images' => $images,
        ]);
    }

    public function favorite()
    {
        $id = Auth::id();
        $fav_recipes = Favorite::with(['recipe'])->where('user_id', $id)->orderBy('created_at', 'desc')->get();
        return view('homepage.favorite', [
            'fav_recipes' => $fav_recipes,
        ]);
    }
}
