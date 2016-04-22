<?php

$query = "
SELECT
    COUNT(0) as aggregate
FROM (

    SELECT
        'menu' as produto_tipo,
        (
          SELECT
            round(avg(nota), 0)
          FROM
            avaliacao
          WHERE
            avaliacao.fk_chef = menu.fk_chef and avaliacao.ind_aprovado = 1
        ) as reputacao
    FROM
      menu
    INNER JOIN
      chef ON chef.id_chef = menu.fk_chef
    INNER JOIN
      users ON chef.id_chef = users.id
    INNER JOIN
      menu_culinaria ON menu_culinaria.fk_menu = menu.id_menu
    INNER JOIN
      menu_refeicao ON menu_refeicao.fk_menu = menu.id_menu
    WHERE
      menu.ind_ativo = 1 AND
      menu.fk_status = 2
    #WHERE#
    GROUP BY
      menu.id_menu
    #HAVING#

    UNION ALL

    SELECT
        'curso' as produto_tipo,
        (
          SELECT
            round(avg(nota), 0)
          FROM
            avaliacao
          WHERE
            avaliacao.fk_chef = curso.fk_chef and avaliacao.ind_aprovado = 1
        ) as reputacao
    FROM
      curso
    INNER JOIN
      curso_culinaria ON curso_culinaria.fk_curso = curso.id_curso
    INNER JOIN
      curso_refeicao ON curso_refeicao.fk_curso = curso.id_curso
    INNER JOIN
      chef ON chef.id_chef = curso.fk_chef
    INNER JOIN
      users ON chef.id_chef = users.id
    WHERE
      curso.ind_ativo = 1 AND
      curso.fk_status = 2
    #WHERE#
    GROUP BY
      curso.id_curso
    #HAVING#

) as resultado
WHERE
  1=1
";

$filtros = [];
$having = [];
$bindings = $params;

if (isset($params['tipo'])) {
    $query .= " AND resultado.produto_tipo = :tipo";
}

if (isset($params['id_culinaria'])) {
    $filtros[] = sprintf("fk_culinaria IN(%s)", implode(",", $params['id_culinaria']));
    unset($bindings['id_culinaria']);
}

if (isset($params['preco'])) {
    $filtros[] = sprintf("preco BETWEEN %s AND %s", $params['preco'][0], $params['preco'][1]);
    unset($bindings['preco']);
}

if (isset($params['id_tipo_refeicao'])) {
    $filtros[] = sprintf("fk_tipo_refeicao IN(%s)", implode(",", $params['id_tipo_refeicao']));
    unset($bindings['id_tipo_refeicao']);
}

if (isset($params['reputacao'])) {
    $having[] = sprintf("reputacao IN(%s)", implode(",", $params['reputacao']));
    unset($bindings['reputacao']);
}

if (isset($params['id_cidade'])) {
    $filtros[] = sprintf("chef.fk_cidade = %s", $params['id_cidade']);
    unset($bindings['id_cidade']);
}

if (isset($params['id_chef_status'])) {
    $filtros[] = sprintf("chef.fk_status = %s", $params['id_chef_status']);
    unset($bindings['id_chef_status']);
}

$filtros = !empty($filtros) ? (" AND " . implode(" AND ", $filtros)) : "";
$having = !empty($having) ? (" HAVING " . implode(" AND ", $having)) : "";

$query = str_replace("#WHERE#", $filtros, $query);
$query = str_replace("#HAVING#", $having, $query);