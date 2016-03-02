<?php

$query = "
SELECT
  cc.id_conta_bancaria,
  cc.banco_agencia,
  cc.banco_agencia_digito,
  if(cc.banco_agencia_digito is null, cc.banco_agencia, concat(cc.banco_agencia, '-', cc.banco_agencia_digito)) as agencia_descricao,
  cc.banco_conta,
  cc.banco_conta_digito,
  concat(cc.banco_conta, '-', cc.banco_conta_digito) as conta_descricao,
  banco.id_banco,
  banco.nome_banco,
  concat(banco.id_banco, ' - ', banco.nome_banco) as banco_descricao,
  cc.banco_proprietario_conta
FROM
  chef_conta_bancaria cc
INNER JOIN
  banco on banco.id_banco = cc.fk_banco
WHERE
  fk_chef = :id_chef
";