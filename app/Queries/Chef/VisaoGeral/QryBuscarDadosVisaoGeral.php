<?php

$query = "
SELECT
  chef.*,
  users.name as nome,
  users.email,
  concat(users.name, ' ', chef.sobrenome) as nome_completo,
  date_format(chef.data_nascimento, '%d/%m/%Y') as data_nascimento,
  date_format(chef.created_at, '%d/%m/%Y %H:%i') as cadastrado_em,
  chef.fk_sexo as sexo,
  sexo.descricao as sexo_descricao,
  IFNULL(chef.avatar, :avatar) as avatar,
  IFNULL(chef.foto_capa, :foto_capa) as foto_capa,
  date_format(chef.moip_created_at, '%d/%m/%Y %H:%i') as moip_data_cadastro,
  cidade.nome_cidade as cidade,
  estado.nome_estado as estado,
  pais.nome_pais as pais,
  chef_status.descricao as status,
  chef_status.cor_texto,
  chef_selo_status.descricao as status_selo
FROM
  chef
INNER JOIN
  chef_status ON chef.fk_status = chef_status.id_chef_status
INNER JOIN
  chef_selo_status ON chef.fk_selo_status = chef_selo_status.id_selo_status
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
  chef.id_chef = :id
";