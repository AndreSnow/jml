<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class RectorRunCommand extends Command
{
    protected $signature = 'rector:run';

    protected $description = 'Executa o Rector e aplica as mudanças';

    public function handle(): int
    {
        $this->info('Executando o Rector e aplicando correções...');

        $process = new Process(['vendor/bin/rector', 'process']);
        $process->setTimeout(null);
        $process->run(function ($type, $buffer): void {
            echo $buffer;
        });

        return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
    }
}
