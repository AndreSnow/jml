<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class RectorRunCustomFileCommand extends Command
{
    protected $signature = 'rector:custom 
                            {--config=rector.php : Caminho do arquivo de configuração personalizado}';

    protected $description = 'Executa o Rector com um arquivo de configuração personalizado';

    public function handle(): int
    {
        $configPath = $this->option('config');

        if (!file_exists($configPath)) {
            $this->error('Arquivo de configuração não encontrado: ' . $configPath);
            return Command::FAILURE;
        }

        $this->info('Executando o Rector com o arquivo de configuração: ' . $configPath);

        $process = new Process(['vendor/bin/rector', 'process', '--config=' . $configPath]);
        $process->setTimeout(null);
        $process->run(function ($type, $buffer): void {
            echo $buffer;
        });

        return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;
    }
}
