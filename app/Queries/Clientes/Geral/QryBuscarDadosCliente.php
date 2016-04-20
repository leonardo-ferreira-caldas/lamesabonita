<?php

$query = "
SELECT
  degustador.*,
  DATE_FORMAT(degustador.data_nascimento, '%d/%m/%Y') as data_nascimento,
  users.name as nome,
  users.email,
  degustador_endereco.cep,
  degustador_endereco.bairro,
  degustador_endereco.logradouro_numero,
  degustador_endereco.logradouro,
  degustador_endereco.fk_cidade,
  degustador_endereco.complemento,
  degustador_endereco.fk_estado,
  pais.nome_pais
FROM
  degustador
INNER JOIN
  users ON users.id = degustador.id_degustador
LEFT JOIN
  degustador_endereco ON degustador_endereco.fk_degustador = degustador.id_degustador AND degustador_endereco.ind_endereco_principal = true
LEFT JOIN
  pais ON degustador_endereco.fk_pais = pais.id_pais
WHERE
  degustador.id_degustador = :id_cliente
";