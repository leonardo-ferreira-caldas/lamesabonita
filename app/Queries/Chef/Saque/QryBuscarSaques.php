<?php

$query = "
SELECT
  saque.id_saque,
  saque.valor_saque,
  saque.valor_taxa,
  DATE_FORMAT(saque.created_at, '%d/%m/%Y') as data_solicitacao,
  saque_status.descricao as status,
  concat(banco.id_banco, ' - ', banco.nome_banco) as banco_descricao,
  concat(chef_conta_bancaria.banco_conta, '-', chef_conta_bancaria.banco_conta_digito) as conta_descricao,
  concat(chef_conta_bancaria.banco_agencia, '-', chef_conta_bancaria.banco_agencia_digito) as agencia_descricao
FROM
  saque
INNER JOIN
  saque_status on saque_status.id_saque_status = saque.fk_saque_status
INNER JOIN
  chef_conta_bancaria on chef_conta_bancaria.id_conta_bancaria = saque.fk_conta_bancaria
INNER JOIN
  banco on banco.id_banco = chef_conta_bancaria.fk_banco
WHERE
  saque.fk_chef = :id_chef
";