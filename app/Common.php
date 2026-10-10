<?php

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;


/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */


if (! function_exists('blade_view')) {
    function blade_view(string $vista, array $datos = []): string
    {
        $archivos = new Filesystem();
        $eventos  = new Dispatcher(new Container());

        $compilador = new BladeCompiler($archivos, WRITEPATH . 'cache/blade');

        $resolvedor = new EngineResolver();
        $resolvedor->register('blade', fn () => new CompilerEngine($compilador, $archivos));

        $buscador = new FileViewFinder($archivos, [APPPATH . 'Views']);

        $fabrica = new Factory($resolvedor, $buscador, $eventos);
        $fabrica->addExtension('blade.php', 'blade');

        return $fabrica->make($vista, $datos)->render();
    }
}