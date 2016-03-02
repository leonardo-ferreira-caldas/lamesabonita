<?php

namespace App\Facades;

use Illuminate\Support\Str;
use App\Exceptions\NotAllowedException;
use App\Formatters\Vector;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Upload {

    private static $mimesPermitidos = ['image/jpeg', 'image/png'];
    private static $uploaded = [];

    const UPLOAD_PATH = 'images/uploads/';

    /**
     * Returna o caminho de upload para um arquivo
     *
     * @param string $nomeArquivo
     * @return string Path
     */
    public static function getUploadPath($nomeArquivo) {
        return self::UPLOAD_PATH . $nomeArquivo;
    }

    /**
     * Deleta um arquivo enviado
     *
     * @param string $nomeArquivo
     * @return void
     */
    public static function deletar($nomeArquivo) {
        @unlink(self::getUploadPath($nomeArquivo));
    }

    /**
     * Salva um arquivo enviado
     *
     * @param UploadedFile $file
     * @param string $identificador
     * @return string Nome do arquivo salvo
     */
    public static function salvar(UploadedFile $file, $identificador) {
        if (!$file->isValid()) {
            return;
        } else if (!self::isExtensaoValida($file->getMimeType())) {
            throw new NotAllowedException('Arquivo não permitido!\nSomente imagens com extensões .jpg, .jpeg, .png são permitidas.');
        }

        $nomeArquivoNormalizado = self::normalizarNomeArquivo($file->getClientOriginalName(), $identificador);

        $file->move(self::UPLOAD_PATH, $nomeArquivoNormalizado);

        self::$uploaded[] = $nomeArquivoNormalizado;

        return $nomeArquivoNormalizado;

    }

    /**
     * Valida se o mime type de um arquivo é permitido
     *
     * @param $mimeType
     * @return bool
     */
    public static function isExtensaoValida($mimeType) {
        return in_array($mimeType, self::$mimesPermitidos);
    }

    /**
     * Normaliza o nome do arquivo para ser salvo
     *
     * @param string nome
     * @return string
     */
    public static function normalizarNomeArquivo($nomeArquivo, $identificador) {
        return sprintf('%s_%s%s.%s', Str::slug($identificador), rand(100000, 999999), time(), Vector::splitAndGetLast($nomeArquivo, '.'));
    }

    /**
     * Deleta todos os arquivos salvos durante toda a requisição
     *
     * @return void
     */
    public static function rollback() {
        foreach (self::$uploaded as $nomeArquivo) {
            self::deletar($nomeArquivo);
        }
    }
}