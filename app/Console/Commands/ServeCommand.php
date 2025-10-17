<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ServeCommand as BaseServeCommand;

class ServeCommand extends BaseServeCommand
{
    protected function serverCommand()
    {
        $publicPath = base_path('public_html');
        
        return [
            (new \Symfony\Component\Process\PhpExecutableFinder)->find(false),
            '-S',
            $this->host().':'.$this->port(),
            '-t',
            $publicPath,
            $publicPath.'/index.php',
        ];
    }
}