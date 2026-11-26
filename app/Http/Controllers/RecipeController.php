<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

final class RecipeController extends Controller
{
    public function index(): View
    {
        return view('recipes.index');
    }
}
