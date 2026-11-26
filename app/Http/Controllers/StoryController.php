<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

final class StoryController extends Controller
{
    public function show(): Response
    {
        return response()->view('pages.story');
    }
}
