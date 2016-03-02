<?php

$query = "
SELECT
  menu.id_menu,
  menu.titulo,
  menu.preco,
  menu.slug,
  concat(users.name, ' ', chef.sobrenome) as nome_completo
FROM
  menu
INNER JOIN
  chef ON chef.id_chef = menu.fk_chef
INNER JOIN
  users ON users.id = chef.id_chef
WHERE
  menu.fk_status = :id_status
";