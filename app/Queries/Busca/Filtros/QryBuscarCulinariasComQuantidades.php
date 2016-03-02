<?php

$query = "
SELECT
  culinaria.id_culinaria,
  culinaria.nome_culinaria,
  IFNULL(

    (SELECT count(0)
      FROM menu_culinaria
      INNER JOIN menu ON menu_culinaria.fk_menu = menu.id_menu AND menu.ind_ativo = 1
      WHERE fk_culinaria = culinaria.id_culinaria) +

    (SELECT count(0) FROM curso_culinaria
     INNER JOIN curso ON curso_culinaria.fk_curso = curso.id_curso AND curso.ind_ativo = 1
     WHERE fk_culinaria = culinaria.id_culinaria)

  , 0) AS qtd_produtos
FROM
  culinaria
ORDER BY
  culinaria.nome_culinaria ASC
";