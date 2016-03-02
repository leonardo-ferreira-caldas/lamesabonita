<?php

$query = "
SELECT
  tipo_refeicao.id_tipo_refeicao,
  tipo_refeicao.nome_tipo_refeicao,

  IFNULL(

    (SELECT count(0) FROM menu_refeicao
    INNER JOIN menu ON menu_refeicao.fk_menu = menu.id_menu AND menu.ind_ativo = 1
    WHERE fk_tipo_refeicao = tipo_refeicao.id_tipo_refeicao) +

    (SELECT count(0) FROM curso_refeicao
    INNER JOIN curso ON curso_refeicao.fk_curso = curso.id_curso AND curso.ind_ativo = 1
    WHERE fk_tipo_refeicao = tipo_refeicao.id_tipo_refeicao)

  , 0) AS qtd_produtos
FROM
  tipo_refeicao
ORDER BY
  tipo_refeicao.nome_tipo_refeicao ASC
";