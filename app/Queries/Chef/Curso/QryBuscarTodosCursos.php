<?php

$query = "
SELECT
  curso.id_curso,
  curso.titulo,
  curso.preco,
  curso.slug,
  CAST(curso.ind_ativo AS SIGNED) as ind_ativo,
  curso.fk_status,
  produto_status.descricao as status_descricao,
  produto_status.cor_texto as status_cor,
  concat(users.name, ' ', chef.sobrenome) as nome_completo
FROM
  curso
INNER JOIN
  produto_status ON produto_status.id_produto_status = curso.fk_status
INNER JOIN
  chef ON chef.id_chef = curso.fk_chef
INNER JOIN
  users ON users.id = chef.id_chef
";