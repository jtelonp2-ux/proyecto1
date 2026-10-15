<?php

namespace App\Controllers;

class Language extends BaseController
{
    public function set(string $idioma)
    {
        if (in_array($idioma, ['en', 'es'], true)) {
            session()->set('lang', $idioma);
        }

        return redirect()->back();
    }
}