<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Emails\Email;
use Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
use Mail;

class EmailJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Email $email) {
        $this->email = $email;
    }

    public function failed() {
        Log::error(sprintf("Não foi possível enviar o email para a class '%s'.", get_class($this->email)));
    }

    private function logsAntesEnvio() {
        Log::info(
            sprintf('Enviando email para %s <%s> com assunto %s.',
                $this->email->getNome(),
                $this->email->getEmail(),
                $this->email->getAssunto()
            ));
        Log::info('View do Email: ' . $this->email->getView());
        Log::info('Variaveis: ' . print_r($this->getVariaveis(), true));
    }

    private function logsDepoisEnvio($response) {
        Log::info('Resposta de envio de email: ' . print_r($response, true));
    }

    private function getViewHTML() {
        return view($this->email->getView(), $this->getVariaveis())->render();
    }

    private function getViewCSSParseado() {
        $cssToInlineStyles = new CssToInlineStyles();
        $cssToInlineStyles->setHTML($this->getViewHTML());
        $cssToInlineStyles->setUseInlineStylesBlock(true);
        return $cssToInlineStyles->convert();
    }

    private function getVariaveis() {
        $variables = $this->email->getVariavies() ?: [];
        return array_merge($variables, [
            'assunto' => $this->email->getAssunto()
        ]);
    }

    private function normalize($email) {
        $email = trim($email);
        $exploded = explode("@", $email);
        $address = explode("+", $exploded[0])[0];
        return trim($address . "@" . $exploded[1]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {

        $bodyEmail = $this->getViewCSSParseado();

        $this->logsAntesEnvio();

        $sendTo = [
            'email'   => $this->normalize($this->email->getEmail()),
            'nome'    => $this->email->getNome(),
            'assunto' => $this->email->getAssunto(),
            'anexos'  => $this->email->getAnexos()
        ];

        $bindings = [
            'body' => $bodyEmail
        ];

        $response = Mail::send('emails.template', $bindings, function ($message) use ($sendTo) {
            $message->to($sendTo['email'], $sendTo['nome']);
            $message->subject($sendTo['assunto']);

            foreach ($sendTo['anexos'] as $anexo) {
                $message->attach($anexo);
            }
        });

        $this->logsDepoisEnvio($response);

    }
}
