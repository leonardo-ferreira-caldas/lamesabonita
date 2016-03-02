<?php

$query = "
SELECT
  avaliacao.id_avaliacao,
  avaliacao.texto,
  avaliacao.nota,
  DATE_FORMAT(avaliacao.created_at, '%d/%m/%Y') as data_avaliacao,
  IFNULL(degustador.avatar, :avatar) as avatar,
  users.name as nome_cliente
FROM
  avaliacao
INNER JOIN
  menu ON menu.id_menu = avaliacao.fk_produto
INNER JOIN
  degustador ON degustador.id_degustador = avaliacao.fk_degustador
INNER JOIN
  users ON users.id = degustador.id_degustador
WHERE
  avaliacao.fk_produto = :id_menu AND
  avaliacao.fk_tipo_avaliacao = :id_tipo AND
  avaliacao.ind_aprovado = true
";