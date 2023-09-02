<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JoggApp\GoogleTranslate\GoogleTranslateFacade as GoogleTranslate;

class TranslateViews
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $language = $request->cookie('language'); // Get selected language

        // We must have a valid translatable content and user has selected a
        // language for translation and most importantly is the translation
        // feature enabled :)
        if ($response->original && is_string($language) && $language != 'en' && config('googletranslate.enabled')) {
            // If selected language is default language then do not translate
            if ($language === config('googletranslate.default_target_translation'))
                return $response;

            // Translate the contents of webpage
            $translation = GoogleTranslate::translate($response->original, to: $language, format: 'html');

            // Replace the response with translated contents
            $response->setContent($translation['translated_text']);
        }

        return $response;
    }
}
