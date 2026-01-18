<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocalizationController extends Controller
{

    public function setLanguage(Request $request, $language)
    {

        if (!in_array($language, ['ua', 'en'])) {
            return response()->json(['error' => 'Invalid language'], 400);
        }

        session(['language' => $language]);
        
        App::setLocale($language);

        return response()->json(['success' => true, 'language' => $language])
            ->cookie('language', $language, 60 * 24 * 30); 
    }

    public function getLanguage()
    {
        $language = session('language', 'ua'); 
        
        return response()->json(['language' => $language]);
    }
}
