<?php

$query = "
SELECT
  sum(if(saque.fk_saque_status = 2, (saque.valor_saque - saque.valor_taxa), 0)) as total_sacado,
  sum(if(saque.fk_saque_status = 1, (saque.valor_saque - saque.valor_taxa), 0)) as aguardando_conclusao
FROM
  saque
WHERE
  saque.fk_chef = :id_chef
";