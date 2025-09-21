<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class RectorDiffCommand extends Command
{
    protected $signature = 'rector:diff';

    protected $description = 'Executa o Rector em modo diff (sem aplicar mudanças)';

    public function handle(): int
    {
        $this->info('Rodando Rector em modo diff...');

        $process = new Process(['vendor/bin/rector', 'process', '--dry-run']);
        $process->setTimeout(null); // evita timeout
        $process->run(function ($type, $buffer): void {
            echo $buffer;
        });

        return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
    }
}
