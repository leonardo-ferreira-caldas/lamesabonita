<?php

$query = "
SELECT
  fk_curso as id_curso,
  qtd_minima_clientes,
  preco
FROM
  curso_preco
WHERE
  fk_curso IN (%s)
ORDER BY
  fk_curso ASC,
  qtd_minima_clientes ASC
";

$in = array_fill(0, count($params['id_curso']), '?');
$query = sprintf($query, implode(",", $in));

$bindings = $params['id_curso'];