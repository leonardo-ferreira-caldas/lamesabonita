<?php

$query = "
SELECT
  degustador_endereco.*,
  cidade.nome_cidade,
  estado.nome_estado,
  pais.nome_pais
FROM
  degustador_endereco
INNER JOIN
  cidade ON degustador_endereco.fk_cidade = cidade.id_cidade
INNER JOIN
  estado ON cidade.fk_estado = estado.id_estado
INNER JOIN
  pais ON degustador_endereco.fk_pais = pais.id_pais
WHERE
  degustador_endereco.fk_degustador = :id_cliente
";