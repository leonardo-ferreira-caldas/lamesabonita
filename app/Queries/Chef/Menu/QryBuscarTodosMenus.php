<?php

$query = "
SELECT
  menu.id_menu,
  menu.titulo,
  menu.preco,
  menu.slug,
  menu.fk_status,
  CAST(menu.ind_ativo AS SIGNED) as ind_ativo,
  produto_status.descricao as status_descricao,
  produto_status.cor_texto as status_cor,
  concat(users.name, ' ', chef.sobrenome) as nome_completo
FROM
  menu
INNER JOIN
  produto_status ON produto_status.id_produto_status = menu.fk_status
INNER JOIN
  chef ON chef.id_chef = menu.fk_chef
INNER JOIN
  users ON users.id = chef.id_chef
";