<?php

$query = "
SELECT
  max(maximo_preco) as maximo_preco,
  min(minimo_preco) as minimo_preco
FROM (

  SELECT
    max(menu.preco) as maximo_preco,
    min(menu.preco) as minimo_preco
  FROM
    menu
  WHERE
    menu.ind_ativo = 1

  UNION ALL

  SELECT
    max(curso.preco) as maximo_preco,
    min(curso.preco) as minimo_preco
  FROM
    curso
  WHERE
    curso.ind_ativo = 1

) as resultado
";