<?php

$query = "
SELECT
  *
FROM (

  SELECT

    IFNULL(
        SUM(
          (SELECT COUNT(0) FROM menu WHERE menu.fk_chef = resultado.fk_chef AND ind_ativo = 1 and fk_status = 2) +
          (SELECT COUNT(0) FROM curso WHERE curso.fk_chef = resultado.fk_chef AND ind_ativo = 1 and fk_status = 2)
        ),
    0) as qtd,

    1 as stars
  FROM (
         SELECT
           ROUND(AVG(avaliacao.nota), 0) reputacao,
           avaliacao.fk_chef
         FROM
           avaliacao
         GROUP BY
           avaliacao.fk_chef
         HAVING
           reputacao = 1
       ) as resultado

  UNION ALL

  SELECT

    IFNULL(
        SUM(
          (SELECT COUNT(0) FROM menu WHERE menu.fk_chef = resultado.fk_chef AND ind_ativo = 1 and fk_status = 2) +
          (SELECT COUNT(0) FROM curso WHERE curso.fk_chef = resultado.fk_chef  AND ind_ativo = 1 and fk_status = 2)
        ),
    0) as qtd,

    2 as stars
  FROM (
         SELECT
           ROUND(AVG(avaliacao.nota), 0) reputacao,
           avaliacao.fk_chef
         FROM
           avaliacao
         GROUP BY
           avaliacao.fk_chef
         HAVING
           reputacao = 2
       ) as resultado

  UNION ALL

  SELECT

    IFNULL(
        SUM(
          (SELECT COUNT(0) FROM menu WHERE menu.fk_chef = resultado.fk_chef AND ind_ativo = 1 and fk_status = 2) +
          (SELECT COUNT(0) FROM curso WHERE curso.fk_chef = resultado.fk_chef  AND ind_ativo = 1 and fk_status = 2)
        ),
    0) as qtd,

    3 as stars
  FROM (
         SELECT
           ROUND(AVG(avaliacao.nota), 0) reputacao,
           avaliacao.fk_chef
         FROM
           avaliacao
         GROUP BY
           avaliacao.fk_chef
         HAVING
           reputacao = 3
       ) as resultado

  UNION ALL

  SELECT

    IFNULL(
        SUM(
          (SELECT COUNT(0) FROM menu WHERE menu.fk_chef = resultado.fk_chef AND ind_ativo = 1 and fk_status = 2) +
          (SELECT COUNT(0) FROM curso WHERE curso.fk_chef = resultado.fk_chef  AND ind_ativo = 1 and fk_status = 2)
        ),
    0) as qtd,

    4 as stars
  FROM (
         SELECT
           ROUND(AVG(avaliacao.nota), 0) reputacao,
           avaliacao.fk_chef
         FROM
           avaliacao
         GROUP BY
           avaliacao.fk_chef
         HAVING
           reputacao = 4
       ) as resultado

  UNION ALL

  SELECT

    IFNULL(
        SUM(
          (SELECT COUNT(0) FROM menu WHERE menu.fk_chef = resultado.fk_chef AND ind_ativo = 1 and fk_status = 2) +
          (SELECT COUNT(0) FROM curso WHERE curso.fk_chef = resultado.fk_chef  AND ind_ativo = 1 and fk_status = 2)
        ),
    0) as qtd,

    5 as stars
  FROM (
         SELECT
           ROUND(AVG(avaliacao.nota), 0) reputacao,
           avaliacao.fk_chef
         FROM
           avaliacao
         GROUP BY
           avaliacao.fk_chef
         HAVING
           reputacao = 5
       ) as resultado

) as resultado
ORDER BY stars DESC
";