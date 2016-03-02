<?php

$query = "
SELECT
  faq.id_faq,
  faq.pergunta,
  faq.resposta,
  faq_tipo.id_faq_tipo,
  faq_tipo.descricao as tipo
FROM
  faq
INNER JOIN
  faq_tipo on faq_tipo.id_faq_tipo = faq.fk_tipo
WHERE
  faq_tipo.ind_chef = :ind_chef
";