<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Queues\Email as FilaEmail;

class Email extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:processar_fila';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processa a fila de emails';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        FilaEmail::processar();
    }
}
