<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\Rule;
use JoggApp\GoogleTranslate\GoogleTranslateFacade as GoogleTranslate;

class TranslationController extends Controller
{
    public function index(Request $request): RedirectResponse
    {
        $request->validate([
            'lang' => [
                'required',
                'string',
                'min:2',
                'max:3',
                Rule::in(GoogleTranslate::languages())
            ]
        ]);

        // Save selection for one week
        Cookie::queue('language', $request->query('lang'), 60 * 24 * 7);

        return redirect()
            ->back()
            ->with('updated', 'Your language choice was updated');
    }
}
