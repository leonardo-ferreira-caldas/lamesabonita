<?php

$query = "
SELECT
  curso.*,
  chef.slug as chef_slug,

  IF(curso.ind_ativo = 1, 'Sim', 'Não') as ativo_descricao,
  IF(curso.ind_ativo = 1, 'green', 'red') as ativo_cor,

  produto_status.descricao as descricao_status,
  produto_status.cor_texto as cor_status,

  IFNULL((SELECT curso_imagem.nome_imagem FROM curso_imagem WHERE curso_imagem.fk_curso = curso.id_curso AND curso_imagem.ind_capa = 1), :sem_foto) foto_capa,

  (SELECT
    group_concat(culinaria.nome_culinaria SEPARATOR ' / ')
  FROM
    curso_culinaria
  INNER JOIN
    culinaria ON curso_culinaria.fk_culinaria = culinaria.id_culinaria
  WHERE
    curso_culinaria.fk_curso = curso.id_curso
  ) as culinarias,

  (SELECT
    group_concat(tipo_refeicao.nome_tipo_refeicao SEPARATOR ' / ')
  FROM
    curso_refeicao
  INNER JOIN
    tipo_refeicao ON curso_refeicao.fk_tipo_refeicao = tipo_refeicao.id_tipo_refeicao
  WHERE
    curso_refeicao.fk_curso = curso.id_curso
  ) as tipos_refeicoes

FROM
  curso
INNER JOIN
  produto_status ON produto_status.id_produto_status = curso.fk_status
INNER JOIN
  chef ON chef.id_chef = curso.fk_chef
WHERE
  curso.fk_chef = :id_chef
GROUP BY curso.id_curso
";