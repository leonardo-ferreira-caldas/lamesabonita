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
  reserva_status.id_reserva_status,
  reserva_status.nome_status as status_reserva,
  DATE_FORMAT(reserva.created_at, '%d/%m/%Y') as data_criacao_reserva,
  IFNULL(menu.titulo, curso.titulo) as titulo_produto,
  IFNULL(menu.preco, curso.preco) as preco_produto,
  user_cliente.email as email_cliente,
  user_cliente.name as nome_cliente,
  chef.sobrenome,
  pagamento_status.id_pagamento_status,
  pagamento_status.nome_pagamento_status,
  concat(user_chef.name, ' ', chef.sobrenome) as chef_nome_completo,

  CASE
    WHEN pagamento_status.id_pagamento_status = 1
      THEN 'label-status-pendente'
    WHEN pagamento_status.id_pagamento_status = 2
      THEN 'label-status-sucesso'
    ELSE 'label-status-erro'
  END class_status_pagamento

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
  pagamento ON reserva.id_reserva = pagamento.fk_reserva
INNER JOIN
  pagamento_status ON pagamento.fk_pagamento_status = pagamento_status.id_pagamento_status
LEFT JOIN
  menu ON reserva.fk_menu = menu.id_menu
LEFT JOIN
  curso ON curso.id_curso = reserva.fk_curso
GROUP BY reserva.id_reserva
ORDER BY reserva.id_reserva DESC";