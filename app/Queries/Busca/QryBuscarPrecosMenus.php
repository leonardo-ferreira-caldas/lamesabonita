<?php

$query = "
SELECT
  fk_menu as id_menu,
  qtd_minima_clientes,
  preco
FROM
  menu_preco
WHERE
  fk_menu IN (%s)
ORDER BY
  fk_menu ASC,
  qtd_minima_clientes ASC
";

$in = array_fill(0, count($params['id_menu']), '?');
$query = sprintf($query, implode(",", $in));

$bindings = $params['id_menu'];