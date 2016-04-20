<?php

namespace App\Queues;

use App\Formatters\Email as EmailFormatter;
use Carbon\Carbon;
use DB;
use Mail;

class Email implements QueueInterface {

    /**
     * Adiciona um novo email na fila para envio
     *
     * @param array $item
     * @return void
     */
    public static function enfilerar($idEmail)
    {
        DB::table('fila_email')->insert([
            'id_email' => $idEmail
        ]);
    }

    /**
     * Processa a fila atual de emails
     *
     * @param int $length Quantidade de registros a serem processados
     * @return void
     */
    public static function processar($length = 100)
    {

        $filas = DB::table('fila_email')->where('qtd_tentativas_envio', '<', 5)->get();

        foreach ($filas as $fila) {

            try {

                $email = DB::table('email')->where('id_email', $fila->id_email)->first();

                $response = Mail::send('emails.template', ['body' => $email->corpo_email], function ($message) use ($email) {

                    $message->to($email->para_email, $email->para_nome);
                    $message->from($email->de_email, $email->de_nome);
                    $message->subject($email->assunto);

                    foreach (json_decode($email->anexos) as $anexo) {
                        $message->attach($anexo);
                    }

                });

                DB::table('fila_email')->where('id_fila', $fila->id_fila)->delete();
                DB::table('email')->where('id_email', $email->id_email)->update([
                    'ind_enviado' => true,
                    'data_envio' => Carbon::now()->toDateTimeString()
                ]);

            } catch (\Exception $e) {

                DB::table('fila_email')
                    ->where('id_fila', $fila->id_fila)
                    ->update([
                        'log_erro'              => $e->getMessage() . "\n\n" . $e->getTraceAsString(),
                        'qtd_tentativas_envio'  => ++$fila->qtd_tentativas_envio,
                        'data_ultima_tentativa' => Carbon::now()->toDateTimeString()
                    ]);

            }

        }

    }

}