<?php

Route::group(['middleware' => ['web'], 'prefix' => 'backoffice'], function () {

    Route::get('/', 'Admin\AdminController@getDashboard');
    Route::get('dashboard', 'Admin\AdminController@getDashboard')->name('admin.dashboard');

    Route::get('avaliacao/aprovar/{id}', 'Admin\AdminController@getAprovarAvaliacao')->name('admin.avaliacao.aprovar');
    Route::get('avaliacao/reprovar/{id}', 'Admin\AdminController@getReprovarAvaliacao')->name('admin.avaliacao.reprovar');

    Route::post('login', 'Admin\AuthController@postLogin')->name('admin.login.post');
    Route::get('login', 'Admin\AdminController@getLogin')->name('admin.login');
    Route::get('logout', 'Admin\AuthController@getLogout')->name('admin.logout');

    Route::group(['prefix' => 'cadastro'], function () {

        Route::get('tipo_culinaria',          'Admin\Resources\CulinariaResource@getListar')->name('cadastro.tipo_culinaria.listar');
        Route::get('tipo_culinaria/buscar',   'Admin\Resources\CulinariaResource@getBuscarRegistros')->name('cadastro.tipo_culinaria.registros');
        Route::get('tipo_culinaria/salvar',  'Admin\Resources\CulinariaResource@getInserir')->name('cadastro.tipo_culinaria.inserir');
        Route::post('tipo_culinaria/salvar', 'Admin\Resources\CulinariaResource@postSalvar')->name('cadastro.tipo_culinaria.salvar');
        Route::get('tipo_culinaria/editar',   'Admin\Resources\CulinariaResource@getEditar')->name('cadastro.tipo_culinaria.editar');
        Route::get('tipo_culinaria/deletar',  'Admin\Resources\CulinariaResource@getDeletar')->name('cadastro.tipo_culinaria.deletar');

        Route::get('tipo_refeicao',          'Admin\Resources\TipoRefeicaoResource@getListar')->name('cadastro.tipo_refeicao.listar');
        Route::get('tipo_refeicao/buscar',   'Admin\Resources\TipoRefeicaoResource@getBuscarRegistros')->name('cadastro.tipo_refeicao.registros');
        Route::get('tipo_refeicao/salvar',  'Admin\Resources\TipoRefeicaoResource@getInserir')->name('cadastro.tipo_refeicao.inserir');
        Route::post('tipo_refeicao/salvar', 'Admin\Resources\TipoRefeicaoResource@postSalvar')->name('cadastro.tipo_refeicao.salvar');
        Route::get('tipo_refeicao/editar',   'Admin\Resources\TipoRefeicaoResource@getEditar')->name('cadastro.tipo_refeicao.editar');
        Route::get('tipo_refeicao/deletar',  'Admin\Resources\TipoRefeicaoResource@getDeletar')->name('cadastro.tipo_refeicao.deletar');

        Route::get('incluso_preco',          'Admin\Resources\InclusoPrecoResource@getListar')->name('cadastro.incluso_preco.listar');
        Route::get('incluso_preco/buscar',   'Admin\Resources\InclusoPrecoResource@getBuscarRegistros')->name('cadastro.incluso_preco.registros');
        Route::get('incluso_preco/salvar',  'Admin\Resources\InclusoPrecoResource@getInserir')->name('cadastro.incluso_preco.inserir');
        Route::post('incluso_preco/salvar', 'Admin\Resources\InclusoPrecoResource@postSalvar')->name('cadastro.incluso_preco.salvar');
        Route::get('incluso_preco/editar',   'Admin\Resources\InclusoPrecoResource@getEditar')->name('cadastro.incluso_preco.editar');
        Route::get('incluso_preco/deletar',  'Admin\Resources\InclusoPrecoResource@getDeletar')->name('cadastro.incluso_preco.deletar');

        Route::get('faq',          'Admin\Resources\FAQResource@getListar')->name('cadastro.faq.listar');
        Route::get('faq/buscar',   'Admin\Resources\FAQResource@getBuscarRegistros')->name('cadastro.faq.registros');
        Route::get('faq/salvar',   'Admin\Resources\FAQResource@getInserir')->name('cadastro.faq.inserir');
        Route::post('faq/salvar',  'Admin\Resources\FAQResource@postSalvar')->name('cadastro.faq.salvar');
        Route::get('faq/editar',   'Admin\Resources\FAQResource@getEditar')->name('cadastro.faq.editar');
        Route::get('faq/deletar',  'Admin\Resources\FAQResource@getDeletar')->name('cadastro.faq.deletar');

    });

    Route::get('chef',                      'Admin\Resources\ChefResource@getListar')->name('backoffice.chef.listar');
    Route::get('chef/buscar',               'Admin\Resources\ChefResource@getBuscarRegistros')->name('backoffice.chef.registros');
    Route::get('chef/alterar-fotos/{slug}', 'Admin\Resources\ChefResource@getAlterarFotos')->name('backoffice.chef.alterar_fotos');
    Route::post('chef/alterar-foto-perfil/{slug}', 'Admin\Resources\ChefResource@getAlterarFotoPerfil')->name('backoffice.chef.alterar_foto_perfil');
    Route::post('chef/alterar-foto-capa/{slug}', 'Admin\Resources\ChefResource@getAlterarFotoCapa')->name('backoffice.chef.alterar_foto_capa');
    Route::get('chef/buscar_cidade/{id}',   'Admin\Resources\ChefResource@getCidadesEstado')->name('backoffice.chef.cidades');
    Route::get('chef/detalhes/{slug}',      'Admin\Resources\ChefResource@getDetalhes')->name('backoffice.chef.detalhes');
    Route::post('chef/salvar',              'Admin\Resources\ChefResource@postSalvar')->name('backoffice.chef.salvar');
    Route::get('chef/editar/{slug}',        'Admin\Resources\ChefResource@getEditar')->name('backoffice.chef.editar');
    Route::get('chef/novo_registro',        'Admin\Resources\ChefResource@getNovoRegistro')->name('backoffice.chef.novo_registro');
    Route::get('chef/aprovar/{slug}',       'Admin\Resources\ChefResource@getAprovarPerfil')->name('backoffice.chef.aprovar');
    Route::get('chef/reprovar/{slug}',      'Admin\Resources\ChefResource@getReprovarPerfil')->name('backoffice.chef.reprovar');
    Route::get('chef/deletar',              'Admin\Resources\ChefResource@getDeletar')->name('backoffice.chef.deletar');
    Route::get('chef/agenda/salvar/{chef}',         'Admin\Resources\ChefResource@getSalvarAgenda')->name('backoffice.chef.agenda.salvar');
    Route::get('chef/agenda/atualizar/{chef}/{id}', 'Admin\Resources\ChefResource@getAtualizarAgenda')->name('backoffice.chef.agenda.atualizar');
    Route::get('chef/agenda/deletar/{chef}/{id}',   'Admin\Resources\ChefResource@getDeletarAgenda')->name('backoffice.chef.agenda.deletar');

    Route::get('menu',                     'Admin\Resources\MenuResource@getListar')->name('backoffice.menu.listar');
    Route::get('menu/buscar',              'Admin\Resources\MenuResource@getBuscarRegistros')->name('backoffice.menu.registros');
    Route::get('menu/novo_registro',       'Admin\Resources\MenuResource@getNovoRegistro')->name('backoffice.menu.novo_registro');
    Route::get('menu/salvar',              'Admin\Resources\MenuResource@getInserir')->name('backoffice.menu.inserir');
    Route::post('menu/salvar',             'Admin\Resources\MenuResource@postSalvar')->name('backoffice.menu.salvar');
    Route::get('menu/editar/{slug}',       'Admin\Resources\MenuResource@getEditar')->name('backoffice.menu.editar');
    Route::get('menu/aprovar/{slug}',      'Admin\Resources\MenuResource@getAprovar')->name('backoffice.menu.aprovar');
    Route::get('menu/reprovar/{slug}',     'Admin\Resources\MenuResource@getReprovar')->name('backoffice.menu.reprovar');
    Route::get('menu/deletar',             'Admin\Resources\MenuResource@getDeletar')->name('backoffice.menu.deletar');
    Route::get('menu/imagem/deletar/{id}', 'Admin\Resources\MenuResource@getDeletarImagem')->name('backoffice.menu.imagem.deletar');
    Route::get('menu/imagem/capa/{id}',    'Admin\Resources\MenuResource@getDefinirCapa')->name('backoffice.menu.imagem.definir_capa');

    Route::get('curso',                      'Admin\Resources\CursoResource@getListar')->name('backoffice.curso.listar');
    Route::get('curso/buscar',               'Admin\Resources\CursoResource@getBuscarRegistros')->name('backoffice.curso.registros');
    Route::get('curso/inserir',              'Admin\Resources\CursoResource@getInserir')->name('backoffice.curso.inserir');
    Route::post('curso/inserir',             'Admin\Resources\CursoResource@postSalvar')->name('backoffice.curso.salvar');
    Route::get('curso/novo_registro',       'Admin\Resources\CursoResource@getNovoRegistro')->name('backoffice.curso.novo_registro');
    Route::get('curso/editar/{slug}',        'Admin\Resources\CursoResource@getEditar')->name('backoffice.curso.editar');
    Route::get('curso/aprovar/{slug}',       'Admin\Resources\CursoResource@getAprovar')->name('backoffice.curso.aprovar');
    Route::get('curso/reprovar/{slug}',      'Admin\Resources\CursoResource@getReprovar')->name('backoffice.curso.reprovar');
    Route::get('curso/deletar',              'Admin\Resources\CursoResource@getDeletar')->name('backoffice.curso.deletar');
    Route::get('curso/imagem/deletar/{id}',  'Admin\Resources\CursoResource@getDeletarImagem')->name('backoffice.curso.imagem.deletar');
    Route::get('curso/imagem/capa/{id}',     'Admin\Resources\CursoResource@getDefinirCapa')->name('backoffice.curso.imagem.definir_capa');

    Route::get('conta_bancaria',            'Admin\Resources\ContaBancariaResource@getListar')->name('backoffice.conta_bancaria.listar');
    Route::get('conta_bancaria/buscar',     'Admin\Resources\ContaBancariaResource@getBuscarRegistros')->name('backoffice.conta_bancaria.registros');
    Route::post('conta_bancaria/salvar',    'Admin\Resources\ContaBancariaResource@postSalvar')->name('backoffice.conta_bancaria.salvar');
    Route::get('conta_bancaria/editar/{id}','Admin\Resources\ContaBancariaResource@getEditar')->name('backoffice.conta_bancaria.editar');

    Route::get('reservas',            'Admin\Resources\ReservaResource@getListar')->name('backoffice.reserva.listar');
    Route::get('reservas/buscar',     'Admin\Resources\ReservaResource@getBuscarRegistros')->name('backoffice.reserva.registros');
    Route::get('reservas/detalhes/{id}',  'Admin\Resources\ReservaResource@getDetalhes')->name('backoffice.reserva.detalhes');

    Route::get('configuracao',          'Admin\Resources\ConfiguracoesResource@getListar')->name('backoffice.configuracao.listar');
    Route::get('configuracao/buscar',   'Admin\Resources\ConfiguracoesResource@getBuscarRegistros')->name('backoffice.configuracao.registros');
    Route::get('configuracao/salvar',   'Admin\Resources\ConfiguracoesResource@getInserir')->name('backoffice.configuracao.inserir');
    Route::post('configuracao/salvar',  'Admin\Resources\ConfiguracoesResource@postSalvar')->name('backoffice.configuracao.salvar');
    Route::get('configuracao/editar',   'Admin\Resources\ConfiguracoesResource@getEditar')->name('backoffice.configuracao.editar');
    Route::get('configuracao/deletar',  'Admin\Resources\ConfiguracoesResource@getDeletar')->name('backoffice.configuracao.deletar');

    Route::get('email',               'Admin\Resources\EmailResource@getListar')->name('backoffice.email.listar');
    Route::get('email/buscar',        'Admin\Resources\EmailResource@getBuscarRegistros')->name('backoffice.email.registros');
    Route::get('email/detalhes/{id}', 'Admin\Resources\EmailResource@getDetalhes')->name('backoffice.email.detalhes');
    Route::get('email/corpo_email/{id}', 'Admin\Resources\EmailResource@getCorpoEmail')->name('backoffice.email.detalhes');
    Route::get('email/reenviar/{id}',    'Admin\Resources\EmailResource@getReenviar')->name('backoffice.email.reenviar');

});