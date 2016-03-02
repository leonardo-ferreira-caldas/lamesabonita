<?php

$query = "
SELECT
  incluso_preco.id_incluso_preco,
  incluso_preco.descricao,
  incluso_preco.fk_tipo,
  incluso_preco_tipo.id_incluso_preco_tipo,
  incluso_preco_tipo.descricao as tipo
FROM
  incluso_preco
INNER JOIN
  incluso_preco_tipo ON incluso_preco.fk_tipo = incluso_preco_tipo.id_incluso_preco_tipo
";