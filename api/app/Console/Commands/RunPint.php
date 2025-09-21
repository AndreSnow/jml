<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class RunPint extends Command
{
    protected $signature = 'pint {--preset=psr12} {--test}';

    protected $description = 'Executa o Laravel Pint com preset e opções';

    public function handle(): int
    {
        $args = ['vendor/bin/pint'];

        if ($this->option('test')) {
            $args[] = '--test';
        }

        $args[] = '--preset=' . $this->option('preset');

        $process = new Process($args);
        $process->run(function ($type, $buffer): void {
            echo $buffer;
        });

        return $process->isSuccessful() ? 0 : 1;
    }
}
