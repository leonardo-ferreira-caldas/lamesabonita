<?php

$query = "
SELECT
  reserva.id_reserva,
  DATE_FORMAT(reserva.data_reserva, '%d/%m/%Y') as data_reserva,
  TIME_FORMAT(reserva.horario_reserva, '%H:%i') as horario_reserva,
  reserva.qtd_clientes,
  reserva.preco_por_cliente,
  reserva.taxa_lmb,
  reserva.preco_total,
  reserva.observacao,
  reserva.vlr_divisao_chef,
  DATE_FORMAT(reserva.created_at, '%d/%m/%Y') as data_criacao_reserva,
  IFNULL(menu.titulo, curso.titulo) as titulo_produto,
  IFNULL(menu.preco, curso.preco) as preco_produto,
  user_cliente.email as email_cliente,
  user_cliente.name as nome_cliente,
  chef.sobrenome,
  if(reserva_status.id_reserva_status = 3, 'label-status-erro', 'label-status-sucesso') as reserva_status_class,
  reserva_status.nome_status as reserva_status_descricao
FROM
  reserva
INNER JOIN
  degustador on degustador.id_degustador = reserva.fk_degustador
INNER JOIN
  reserva_status on reserva.fk_status = reserva_status.id_reserva_status
INNER JOIN
  chef ON chef.id_chef = reserva.fk_chef
INNER JOIN
  users as user_chef ON chef.id_chef = user_chef.id
INNER JOIN
  users as user_cliente ON degustador.id_degustador = user_cliente.id
INNER JOIN
  degustador_endereco ON reserva.fk_degustador_endereco = degustador_endereco.id_degustador_endereco
INNER JOIN
  pagamento ON reserva.id_reserva = pagamento.fk_reserva AND pagamento.fk_pagamento_status = 2
LEFT JOIN
  menu ON reserva.fk_menu = menu.id_menu
LEFT JOIN
  curso ON curso.id_curso = reserva.fk_curso
WHERE
  reserva.fk_chef = :id_chef
";

$query .= " GROUP BY reserva.id_reserva ORDER BY reserva.id_reserva ASC";