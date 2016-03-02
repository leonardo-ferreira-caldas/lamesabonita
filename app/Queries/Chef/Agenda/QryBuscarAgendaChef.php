<?php

$query = "
SELECT
  chef_agenda.id_chef_agenda,
  DATE_FORMAT(data, '%m-%d-%Y') as data,
  TIME_FORMAT(hora_de, '%H') as hora_de_hora,
  TIME_FORMAT(hora_ate, '%H') as hora_ate_hora,
  TIME_FORMAT(hora_de, '%H:%i') as hora_de,
  TIME_FORMAT(hora_ate, '%H:%i') as hora_ate
FROM
  chef_agenda
WHERE
  chef_agenda.fk_chef = :id_chef AND
  chef_agenda.deleted_at IS NULL
";