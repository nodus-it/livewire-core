<?php

$app = new Illuminate\Foundation\Application($appPath);

$app->singleton(Illuminate\Contracts\Http\Kernel::class, \Illuminate\Foundation\Http\Kernel::class);
$app->singleton(Illuminate\Contracts\Console\Kernel::class, \Illuminate\Foundation\Console\Kernel::class);
$app->singleton(Illuminate\Contracts\Debug\ExceptionHandler::class, \Illuminate\Foundation\Exceptions\Handler::class);


return $app;
