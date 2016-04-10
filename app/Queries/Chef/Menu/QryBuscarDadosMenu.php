<?php

$query = "
SELECT
  menu.*,
  IF(menu.ind_ativo = 1, 'Ativo', 'Inativo') as ativo_descricao,
  IF(menu.ind_ativo = 1, 'green', 'red') as ativo_cor,

  produto_status.descricao as descricao_status,
  produto_status.cor_texto as cor_status,

  chef.slug as chef_slug,
  IFNULL((SELECT menu_imagem.nome_imagem FROM menu_imagem WHERE menu_imagem.fk_menu = menu.id_menu AND menu_imagem.ind_capa = 1), :sem_foto) foto_capa,

  (SELECT
    group_concat(culinaria.nome_culinaria SEPARATOR ' / ')
  FROM
    menu_culinaria
  INNER JOIN
    culinaria ON menu_culinaria.fk_culinaria = culinaria.id_culinaria
  WHERE
    menu_culinaria.fk_menu = menu.id_menu
  ) as culinarias,

  (SELECT
    group_concat(tipo_refeicao.nome_tipo_refeicao SEPARATOR ' / ')
  FROM
    menu_refeicao
  INNER JOIN
    tipo_refeicao ON menu_refeicao.fk_tipo_refeicao = tipo_refeicao.id_tipo_refeicao
  WHERE
    menu_refeicao.fk_menu = menu.id_menu
  ) as tipos_refeicoes,
  
  concat(users.name, ' ', chef.sobrenome) as nome_completo,
  chef.slug as chef_slug

FROM
  menu  
INNER JOIN
  produto_status ON produto_status.id_produto_status = menu.fk_status
INNER JOIN
  chef ON chef.id_chef = menu.fk_chef
INNER JOIN
  users ON users.id = chef.id_chef
WHERE
  %s
";

if (!is_array($params['id_menu'])) {
    $query = sprintf($query, 'menu.id_menu = ' . $params['id_menu']);
} else {
    $query = sprintf($query, 'menu.id_menu in( ' . implode(',', $params['id_menu']) . ')');
}

$bindings = [];

