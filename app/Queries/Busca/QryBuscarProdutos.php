<?php

$query = "
SELECT
    *
FROM (

    SELECT
        menu.id_menu as produto_id,
        menu.slug as produto_slug,
        menu.titulo as produto_titulo,
        menu.preco as produto_preco,
        menu.qtd_maxima_cliente as produto_qtd_maxima_cliente,
        'menu' as produto_tipo,
        IFNULL(menu_imagem.nome_imagem, :menu_capa) as capa,
        chef.id_chef as chef_id,
        chef.slug as chef_slug,
        IFNULL(chef.avatar, :chef_avatar) as chef_avatar,
        users.name as chef_nome,

        ROUND(IFNULL((
          SELECT
            AVG(avaliacao.nota)
          FROM
            avaliacao
          WHERE
            fk_chef = chef.id_chef), 0), 1
        ) as chef_avaliacao_media,

        (
          SELECT
            count(0)
          FROM
            avaliacao
          WHERE
            fk_chef = chef.id_chef
        ) as chef_avaliacao_count,

        (
          SELECT
            round(avg(nota), 0)
          FROM
            avaliacao
          WHERE
            avaliacao.fk_chef = menu.fk_chef
        ) as reputacao

    FROM
      menu
    INNER JOIN
      menu_culinaria ON menu.id_menu = menu_culinaria.fk_menu
    INNER JOIN
      menu_refeicao ON menu.id_menu = menu_refeicao.fk_menu
    INNER JOIN
      chef ON chef.id_chef = menu.fk_chef
    INNER JOIN
      users ON chef.id_chef = users.id
    LEFT JOIN
      menu_imagem ON menu_imagem.fk_menu = menu.id_menu AND menu_imagem.ind_capa = 1
    LEFT JOIN
      avaliacao ON avaliacao.fk_chef = chef.id_chef
    WHERE
      menu.ind_ativo = 1
    #WHERE#
    GROUP BY
      menu.id_menu
    #HAVING#

    UNION ALL

    SELECT
        curso.id_curso as produto_id,
        curso.slug as produto_slug,
        curso.titulo as produto_titulo,
        curso.preco as produto_preco,
        curso.qtd_maxima_cliente as produto_qtd_maxima_cliente,
        'curso' as produto_tipo,
        IFNULL(curso_imagem.nome_imagem, :curso_capa) as capa,
        chef.id_chef as chef_id,
        chef.slug as chef_slug,
        chef.avatar as chef_avatar,
        users.name as chef_nome,

        ROUND(IFNULL((
          SELECT
            AVG(avaliacao.nota)
          FROM
            avaliacao
          WHERE
            fk_chef = chef.id_chef), 0), 1
        ) as chef_avaliacao_media,

        (
          SELECT
            count(0)
          FROM
            avaliacao
          WHERE
            fk_chef = chef.id_chef
        ) as chef_avaliacao_count,

        (
          SELECT
            round(avg(nota), 0)
          FROM
            avaliacao
          WHERE
            avaliacao.fk_chef = curso.fk_chef
        ) as reputacao

    FROM
      curso
    INNER JOIN
      curso_culinaria ON curso.id_curso = curso_culinaria.fk_curso
    INNER JOIN
      curso_refeicao ON curso.id_curso = curso_refeicao.fk_curso
    INNER JOIN
      chef ON chef.id_chef = curso.fk_chef
    INNER JOIN
      users ON chef.id_chef = users.id
    LEFT JOIN
      curso_imagem ON curso_imagem.fk_curso = curso.id_curso AND curso_imagem.ind_capa = 1
    LEFT JOIN
      avaliacao ON avaliacao.fk_chef = chef.id_chef
    WHERE
      curso.ind_ativo = 1
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

$filtros = !empty($filtros) ? (" AND " . implode(" AND ", $filtros)) : "";
$having = !empty($having) ? (" HAVING " . implode(" AND ", $having)) : "";

$query = str_replace("#WHERE#", $filtros, $query);
$query = str_replace("#HAVING#", $having, $query);

$query .= " LIMIT :offset, :length";