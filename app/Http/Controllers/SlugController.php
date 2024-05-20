<?php

namespace App\Http\Controllers;

use App\Enums\Api\HttpResponseCodes;
use App\Lib\SlugHelper;
use Illuminate\Http\Request;
use Spatie\Sluggable\Slug;

class SlugController extends Controller
{
    public function checkUnique(Request $request)
    {
        $validatedData = $request->validate([
            'slug' => ['required', 'string', 'regex:/^[a-z0-9\-]{1,50}$/'],
            'context' => ['required', 'string', 'in:league,organization'],
        ]);

        $slug = $validatedData['slug'];
        $context = $validatedData['context'];

        $exists = SlugHelper::checkSlugExists($slug, $context);

        if ($exists) {
            return response()->json(['unique' => false], HttpResponseCodes::HttpConflict->value);
        } else {
            return response()->json(['unique' => true], HttpResponseCodes::HttpOK->value);
        }
    }

    public function generateSlug(Request $request)
    {
        //
    }
}
