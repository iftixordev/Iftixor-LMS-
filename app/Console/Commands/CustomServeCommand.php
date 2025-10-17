<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

class CustomServeCommand extends Command
{
    protected $signature = 'serve {--host=127.0.0.1} {--port=8000}';
    protected $description = 'Serve the application on the PHP development server using public_html';
    
    public function handle()
    {
        $host = $this->option('host');
        $port = $this->option('port');
        $publicPath = base_path('public_html');
        
        $this->info("Laravel development server started: http://{$host}:{$port}");
        
        $command = [
            (new PhpExecutableFinder)->find(false),
            '-S',
            $host.':'.$port,
            '-t',
            $publicPath,
        ];
        
        $process = new Process($command, $publicPath);
        $process->setTimeout(null);
        $process->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });
    }
}