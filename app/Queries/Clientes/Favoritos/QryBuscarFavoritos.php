<?php

$query = "
SELECT
  favorito.id_favorito,
  IFNULL(chef.avatar, :avatar) as chef_avatar,
  chef.slug as chef_slug,
  ROUND(AVG(avaliacao.nota), 1) as chef_avaliacao_media,
  COUNT(avaliacao.id_avaliacao) as chef_avaliacao_count,
  IFNULL(menu.titulo, curso.titulo) as produto_titulo,
  IFNULL(menu.preco, curso.preco) as produto_preco,
  IFNULL(menu.slug, curso.slug) as produto_slug,
  IFNULL(IFNULL(menu_imagem.nome_imagem, curso_imagem.nome_imagem), :foto_capa) as produto_foto_capa,
  IF(favorito.fk_menu IS NOT NULL, 'menu', 'curso') as produto_tipo,
  IF(favorito.fk_menu IS NOT NULL,
    CONCAT(
      IF(menu.aperitivo IS NOT NULL, CONCAT('Aperitivos: ', menu.aperitivo), ''),
      IF(menu.entrada IS NOT NULL, CONCAT(' Prato de Entrada: ', menu.entrada), ''),
      CONCAT(' Prato Principal: ', menu.prato_principal),
      IF(menu.sobremesa IS NOT NULL, CONCAT(' Sobremesa: ', menu.sobremesa), '')
    ),
    curso.descricao
  ) as produto_descricao

FROM
  favorito
LEFT JOIN
  menu ON favorito.fk_menu = menu.id_menu
LEFT JOIN
  curso ON favorito.fk_curso = curso.id_curso
LEFT JOIN
  curso_imagem ON curso.id_curso = curso_imagem.fk_curso AND curso_imagem.ind_capa = 1
LEFT JOIN
  menu_imagem ON menu.id_menu = menu_imagem.fk_menu AND menu_imagem.ind_capa = 1
INNER JOIN
  chef ON chef.id_chef = IFNULL(menu.fk_chef, curso.fk_chef)
LEFT JOIN
  avaliacao ON avaliacao.fk_chef = chef.id_chef
WHERE
  favorito.fk_degustador = :id_cliente
GROUP BY favorito.id_favorito
";