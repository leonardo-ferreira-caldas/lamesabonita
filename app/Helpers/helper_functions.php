<?php

use App\Utils\Utils;
use App\Utils\Alert;

function embed_image($imageName) {
    return "data:image/png;base64," . base64_encode(file_get_contents(base_path('resources/assets/img/' . $imageName)));
}

function thumb($image, $width, $height) {
    return route('thumb', ['w' => $width, 'h' => $height, 'i' => $image]);
}

function crop($image, $width, $height) {
    return route('image', ['w' => $width, 'h' => $height, 'i' => $image]);
}

function col_last($counter, $columns) {
    return ($counter+1) % $columns == 0 ? 'col_last' : '';
}

function col_clear($counter, $columns) {
    $clear = '<div class="clear"></div>';

    return ($counter+1) % $columns == 0 ? $clear : '';
}

function checked_in($needle, $haystack, $haystackField) {
    $arrHaystack = array_column($haystack->toArray(), $haystackField);
    if (in_array($needle, $arrHaystack)) {
        return 'checked';
    }
    return null;
}

function column($collection, $field, $separate = ', ') {
    $fields = array_column($collection->toArray(), $field);
    return implode($separate, $fields);
}

function formatar_data_br($data) {
    return Utils::formatarDataBR($data);
}

function formatar_horario($data) {
    return Utils::formatarHorario($data);
}

function formatar_datahora_br($data) {
    return Utils::formatarDataHoraBR($data);
}

function formatar_monetario($valor) {
    if (is_object($valor)) {
        dd($valor);
    }
    return number_format($valor, 2, ',', '.');
}

function redirectWithAlertSuccess($mensagem) {
    Alert::success('Sucesso!', $mensagem);

    return redirect();
}

function redirectWithAlertError($mensagem) {
    Alert::error('Erro!', $mensagem);

    return redirect();
}

function redirectWithAlertWarning($mensagem) {
    Alert::error('Atenção!', $mensagem);

    return redirect();
}

function redirectWithAlertInfo($mensagem) {
    Alert::info('Informação!', $mensagem);

    return redirect();
}