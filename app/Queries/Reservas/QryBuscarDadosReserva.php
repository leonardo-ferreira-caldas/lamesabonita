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
    reserva.vlr_divisao_lmb,
    reserva.porcentagem_chef,
    if(reserva.fk_status = 1, 1, 0) as ind_ativo,
    if(reserva.fk_menu is not null, 1, 0) as ind_menu,
    if(reserva.fk_menu is not null, 'Menu', 'Curso') as produto_tipo,
    DATE_FORMAT(reserva.created_at, '%d/%m/%Y') as data_criacao_reserva,
    DATE_FORMAT(reserva.created_at, '%d/%m/%Y %H:%i') as datahora_criacao_reserva,
    IFNULL(menu.titulo, curso.titulo) as titulo_produto,
    IFNULL(menu.preco, curso.preco) as preco_produto,
    IFNULL(menu.slug, curso.slug) as slug_produto,
    user_cliente.email as email_cliente,
    user_cliente.name as nome_cliente,
    concat(user_chef.name, ' ', chef.sobrenome) as chef_nome,
    user_chef.email as chef_email,
    chef.slug as chef_slug,
    chef.avatar as chef_avatar,
    chef.telefone as chef_telefone,
    reserva_status.nome_status as reserva_status,
    if(reserva_status.id_reserva_status = 3, 'label-status-erro', 'label-status-sucesso') as reserva_status_class,
    degustador.avatar as cliente_avatar,
    degustador.telefone as cliente_telefone,
    degustador_endereco.logradouro,
    degustador_endereco.logradouro_numero,
    degustador_endereco.cep,
    degustador_endereco.bairro,
    cidade.nome_cidade,
    estado.nome_estado,
    pais.nome_pais,
    pagamento_status.nome_pagamento_status as pagamento_status,
    pagamento_cartao.bandeira as pagamento_bandeira,
    pagamento_cartao.numero_cartao as pagamento_numero_cartao,
    pagamento_cartao.titular_cartao as pagamento_titular_cartao,

    CASE
        WHEN pagamento_status.id_pagamento_status = 1
          THEN 'label-status-pendente'
        WHEN pagamento_status.id_pagamento_status = 2
          THEN 'label-status-sucesso'
        ELSE 'label-status-erro'
    END pagamento_status_class
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
  cidade ON cidade.id_cidade = degustador_endereco.fk_cidade
INNER JOIN
  estado ON estado.id_estado = degustador_endereco.fk_estado
INNER JOIN
  pais ON pais.id_pais = degustador_endereco.fk_pais
INNER JOIN
  pagamento ON reserva.id_reserva = pagamento.fk_reserva
INNER JOIN
  pagamento_status ON pagamento.fk_pagamento_status = pagamento_status.id_pagamento_status
INNER JOIN
  pagamento_cartao ON pagamento_cartao.fk_pagamento = pagamento.id_pagamento
LEFT JOIN
  menu ON reserva.fk_menu = menu.id_menu
LEFT JOIN
  curso ON curso.id_curso = reserva.fk_curso
WHERE
  reserva.id_reserva = :id_reserva
";