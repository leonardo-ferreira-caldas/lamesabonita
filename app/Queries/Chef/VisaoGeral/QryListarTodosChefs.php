<?php

$query = "
SELECT
  chef.id_chef,
  users.name as nome,
  users.email,
  chef.sobrenome,
  chef.slug,
  chef.fk_status as status,
  chef_status.descricao as status_descricao,
  IFNULL(chef.avatar, :avatar) as avatar,
  concat(users.name, ' ', chef.sobrenome) as nome_completo,
  date_format(chef.data_nascimento, '%d/%m/%Y') as data_nascimento,
  chef.cpf,
  chef.rg,
  chef.fk_sexo as sexo,
  sexo.descricao as sexo_descricao,
  chef.telefone,
  chef.sobre_chef,
  chef.logradouro,
  chef.logradouro_numero,
  chef.cep,
  cidade.nome_cidade as cidade,
  estado.nome_estado as estado,
  pais.nome_pais as pais
FROM
  chef
INNER JOIN
  chef_status ON chef.fk_status = chef_status.id_chef_status
INNER JOIN
  users ON chef.id_chef = users.id
INNER JOIN
  cidade ON chef.fk_cidade = cidade.id_cidade
INNER JOIN
  estado ON chef.fk_estado = estado.id_estado
INNER JOIN
  pais ON chef.fk_pais = pais.id_pais
INNER JOIN
  sexo ON chef.fk_sexo = sexo.id_sexo
WHERE
  1=1
";

if (isset($params['id_status'])) {
    $query .= " AND chef.fk_status = :id_status";
}