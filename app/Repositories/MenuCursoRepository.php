<?php

namespace App\Repositories;

use Exception;

abstract class MenuCursoRepository {

    protected function removeTmpFilesUploaded()
    {

        $files = $this->request->file($this->getNomeInputImagem());

        foreach ($files as $file) {

            if (!$this->isFileValid($file)) {
                continue;
            }

            $fileName = (string) $file;

            if (!empty($fileName)) {
                @unlink();
            }

        }

    }

    protected function isOwner($idChef)
    {
        return $idChef == $this->user->id;
    }

    protected function isFilesUploaded() {
        $files = $this->request->file($this->getNomeInputImagem());

        foreach ($files as $file) {

            if ($this->isFileValid($file)) {
                return true;
            }

        }

        return false;
    }

    protected function upload($id, $edicao = false)
    {
        $files = $this->request->file($this->getNomeInputImagem());

        if (empty($files) || count($files) == 0) {
            return true;
        }

        $uploaded = 0;

        foreach ($files as $file) {

            if (!$this->isFileValid($file)) {
                continue;
            }

            if (!$this->validateUploadedFile($file->getClientMimeType())) {

            }

            $nomeImagem = $this->getPictureName();
            $this->moveUploadedFile($file, $nomeImagem);
            $this->salvarImagem($id, $nomeImagem);
            $uploaded++;

        }

    }

    protected function getPictureName() {
        return sprintf('%s_chef_pictures_%s.jpg', time() . rand(10000, 99999), $this->user->id);
    }

    protected function moveUploadedFile($file, $pictureName) {
        return $file->move('images/uploads/', $pictureName);
    }

    protected function isFileValid($file) {
        return (is_object($file) && $file->isValid()) && !empty($file);
    }

}