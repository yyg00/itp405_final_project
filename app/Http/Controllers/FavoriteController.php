<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Favorite;
use App\Models\Recipe;
use App\Models\User;
use Auth;
class FavoriteController extends Controller
{
    public function store(Request $request, $id)
    {
        $this->authorize('create', Favorite::class);
        $favorite = new Favorite();
        $favorite->recipe_id = $id;
        $favorite->user_id = Auth::user()->id;
        $favorite->save();
        $recipe = Recipe::find($id);
        return redirect()
        ->route('recipe.show', [
            'id' => $id,
        ])
        ->with('success', "You've added {$recipe->recipe_name} to your favorites.");

    }
    public function delete(Request $request, $id)
    {
        $favorite = Favorite::find($id);
        $this->authorize('delete', $favorite);
        $recipe = Recipe::find($favorite->recipe_id);
        $favorite->delete();
        // return redirect()
        // ->route('recipe.show', [
        //     'id' => $recipe->id,
        // ])
        // ->with('success', "You've removed {$recipe->recipe_name} from your favorites.");
        return redirect()->back()->with('success', "You've removed {$recipe->recipe_name} from your favorites.");
    }
}
