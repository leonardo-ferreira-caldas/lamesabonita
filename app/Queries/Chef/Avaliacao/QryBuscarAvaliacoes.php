<?php

$query = "
SELECT
  avaliacao.id_avaliacao,
  avaliacao.texto,
  avaliacao.nota
FROM
  avaliacao
LEFT JOIN
  menu ON menu.id_menu = avaliacao.fk_produto and avaliacao.fk_tipo_avaliacao = 1
LEFT JOIN
  curso ON curso.id_curso = avaliacao.fk_produto and avaliacao.fk_tipo_avaliacao = 2
WHERE
  avaliacao.ind_aprovado = :ind_aprovado
";