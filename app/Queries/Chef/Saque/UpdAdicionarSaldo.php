<?php

$query = "
UPDATE
    chef
SET
  saldo = saldo + :saldo
WHERE
  id_chef = :id
";