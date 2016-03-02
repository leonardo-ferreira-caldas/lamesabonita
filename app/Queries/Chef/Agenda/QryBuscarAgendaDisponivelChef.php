<?php

$query = "
SELECT
  chef_agenda.id_chef_agenda,
  chef_agenda.data,
  TIME_FORMAT(hora_de, '%H') as hora_de_hora,
  TIME_FORMAT(hora_ate, '%H') as hora_ate_hora,
  TIME_FORMAT(hora_de, '%H:%i') as hora_de,
  TIME_FORMAT(hora_ate, '%H:%i') as hora_ate
FROM
  chef_agenda
WHERE
  chef_agenda.fk_chef = :id_chef AND
  chef_agenda.deleted_at IS NULL AND
  not exists (
    SELECT 1 FROM reserva WHERE fk_status = :id_status AND reserva.data_reserva = chef_agenda.data
  )
";