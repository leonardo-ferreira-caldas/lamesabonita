<?php

$query = "
SELECT
  curso.id_curso,
  curso.titulo,
  curso.preco,
  curso.slug,
  concat(users.name, ' ', chef.sobrenome) as nome_completo
FROM
  curso
INNER JOIN
  chef ON chef.id_chef = curso.fk_chef
INNER JOIN
  users ON users.id = chef.id_chef
WHERE
  curso.fk_status = :id_status
";