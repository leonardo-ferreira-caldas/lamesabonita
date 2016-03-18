<?php

Route::group(['middleware' => ['web']], function () {

    Route::get('log', function() {
        return "<pre>". file_get_contents(storage_path("logs/laravel.log"));
    });

    Route::get('clearlog', function() {
        file_put_contents(storage_path("logs/laravel.log"), '');
        return "";
    });

    Route::post('agenda/salvar', 'ChefAgendaResource@store');
    Route::post('agenda/atualizar/{id}', 'ChefAgendaResource@update');
    Route::post('agenda/deletar/{id}', 'ChefAgendaResource@destroy');

    Route::get('/',                                     'PaginasController@getHome');
    Route::get('sobre-nos',                             'PaginasController@getSobreNos');
    Route::get('nossos-menus-cursos',                   'PaginasController@getProdutos')->name('menus_e_cursos'); // Esta pagina nao é static, mudar para o controller correto
    Route::get('nossos-chefs',                          'PaginasController@getNossosChefs'); // Esta pagina nao é static, mudar para o controller correto
    Route::get('contato',                               'PaginasController@getContato');
    Route::post('contato/enviar',                       'PaginasController@postFormularioContato');
    Route::get('faq',                                   'PaginasController@getFAQ');
    Route::get('termos-de-uso/chef',                    'PaginasController@getTermosChef')->name('termos-chef');
    Route::get('termos-de-uso/degustador',              'PaginasController@getTermosCliente')->name('termos-degustador');
    Route::get('login',                                 'PaginasController@getLogin')->name('post.login');
    Route::get('registrar',                             'PaginasController@getRegistrar')->name('cadastrar.cliente');
    Route::get('sou-chef',                              'PaginasController@getSouChef');
    Route::get('sou-chef/cadastrar',                    'PaginasController@getSouChefCadastrar')->name('cadastrar.chef');
    Route::get('chef/{slug}/perfil',                    'PaginasController@getChefPerfil')->name('chef');
    Route::get('chef/{slug}/cursos',                    'PaginasController@getChefPerfilCursos')->name('chef_perfil_cursos');
    Route::get('chef/{slug}/menus',                     'PaginasController@getChefPerfilMenus')->name('chef_perfil_menus');
    Route::get('chef/{slug}/avaliacoes',                'PaginasController@getChefPerfilAvaliacoes')->name('chef_perfil_avaliacoes');
    Route::get('chef/{slug}/agenda',                    'PaginasController@getChefAgenda')->name('chef_perfil_agenda');
    Route::get('chef/{slug_chef}/menu/{slug_menu}',     'PaginasController@getMenuDetalhes')->name("detalhes_menu");
    Route::get('chef/{slug_chef}/curso/{slug_menu}',    'PaginasController@getCursoDetalhes');
    Route::post('reserva/status',                       'ReservaController@postAtualizarDadosReserva')->name('reserva.atualizar_status');
    Route::post('integracao/atualizar/pagamento',       'IntegracaoController@postAtualizarIntegracaoPagamento')->name('integracao.atualizar_integracao');

    Route::get('filtrar-cidades/{state}',               'GeoController@getCidadesEstados');
    Route::post('buscar-cidades',                       'GeoController@getCidadesByName');

    Route::post('chef/salvar-avaliacao',                'UserController@postSalvarAvaliacao');
    Route::get('favorito/salvar/{slug}/{tipo}',         'UserController@getSalvarFavorito');
    Route::get('favorito/remover/{slug}/{tipo}',        'UserController@getRemoverFavorito');

    Route::get('email/confirmar/{email}/{token}',       'EmailController@getConfirmarEmail')->name('confirmacao-email');
    Route::get('email/aguardando-confirmacao',          'EmailController@getAguardandoConfirmacaoEmail')->name('aguardando-confirmacao-email');
    Route::get('email/reenviar',                        'EmailController@getReenviarConfirmacaoEmail')->name('reenviar-confirmacao-email');

    Route::get('image/{w}/{h}/{i}',                     'ImagemController@crop')->name('image');
    Route::get('thumb/{w}/{h}/{i}',                     'ImagemController@thumb')->name('thumb');

    Route::get('recuperar-senha',                   'Auth\PasswordController@getFormRecuperarSenha');
    Route::get('recuperar-senha/{email}/{token}',   'Auth\PasswordController@getFormAlterarSenha')->name('recuperar-senha');
    Route::post('recuperar-senha/enviar',           'Auth\PasswordController@postRecuperarSenha');
    Route::post('resetar-senha',                    'Auth\PasswordController@postReset');


    Route::get('chef/{slug}/galeria', 'PaginasController@getChefGaleriaFotos')->name('chef-gallery');

    Route::group(['prefix' => 'minha-conta', 'middleware' => 'auth'], function() {

        Route::get('/',                     'ClienteController@visaoGeral')->name('cliente.pagina_inicial');
        Route::get('cartoes',               'ClienteController@cartoes');
        Route::get('informacoes-pessoais',  'ClienteController@informacoesPessoais')->name('degustador.informacoes_pessoais');
        Route::post('alterar-dados',        'ClienteController@postAlterarDados')->name('degustador.alterar_informacoes_pessoais');
        Route::get('reservas',              'ReservaController@getListarReservas')->name('degustador.reservas');
        Route::get('reserva/detalhes/{reserva}', 'ReservaController@getReservaDetalhes')->name('degustador.reserva_detalhes');
        Route::get('reserva/cancelar/{reserva}', 'ReservaController@getCancelarReserva')->name('degustador.cancelar_reserva');
        Route::get('reserva/efeutar-cancelamento/{reserva}', 'ReservaController@getEfetuarCancelamentoReserva')->name('degustador.executar_cancelamento_reserva');
        Route::get('favoritos',             'ClienteController@getListarFavoritos');
        Route::get('newsletter',            'ClienteController@getNewsletter')->name('degustador.newsletter');
        Route::get('alterar-senha',         'ClienteController@alterarSenha');
        Route::post('alterar-foto',         'ClienteController@alterarFoto');
        Route::post('alterar-senha',        'UserController@alterarSenha');
        Route::post('salvar-endereco',      'ClienteController@salvarNovoEndereco')->name("degustador.salvar_endereco");

    });

    Route::get('chef/{slug}/agenda/buscar-horario', 'ChefController@getHorarioData')->name('chef.buscar_horario_data');
    Route::get('chef/aprovar/{slug}/{token}', 'ChefController@getAprovarPerfil')->name('chef.aprovar_perfil');
    Route::get('chef/reprovar/{slug}/{token}', 'ChefController@getReprovarPerfil')->name('chef.reprovar_perfil');

    Route::group(['prefix' => 'chef', 'middleware' => 'auth'], function() {

        Route::get('/',                        'ChefController@getMinhaConta')->name('chef.visao_geral');
        Route::get('minha-conta',              'ChefController@getMinhaConta')->name('conta-chef');
        Route::get('informacoes-pessoais',     'ChefController@getInformacoesPessoais')->name('chef.informacoes_pessoais');
        Route::get('avaliacoes',               'ChefController@getAvaliacoes');
        Route::get('localizacao',              'ChefController@getLocalizacao')->name('chef.localizacao');
        Route::get('pagamento',                'ChefController@getPagamento');
        Route::get('conta-bancaria',           'ChefController@getContaBancaria')->name('chef.dados_bancarios');
        Route::get('conta-bancaria/cadastrar',   'ChefController@getContaBancariaNovo')->name('chef.dados_bancarios.novo');
        Route::get('conta-bancaria/editar/{id}', 'ChefController@getContaBancariaEditar')->name('chef.dados_bancarios.editar');
        Route::get('selo-la-mesa-bonita',      'ChefController@getSeloLMB');
        Route::get('solicitacao-selo-lmb',     'ChefController@getSolicitacaoSelo')->name('solicitacao-selo');
        Route::get('aprovacao-perfil',         'ChefController@getSolicitarAprovacaoPerfil')->name('solicitar-aprovacao-perfil');
        Route::get('aprovar-perfil/{slug}',    'ChefController@getAprovarPerfil')->name('aprovar-perfil');

        Route::post('alterar-senha',        'UserController@alterarSenha');
        Route::get('alterar-senha',         'ChefController@getAlterarSenha');
        Route::get('agenda',                'ChefController@getAgenda');
        Route::post('alterar-capa',         'ChefController@postAlterarFotoCapa');
        Route::post('alterar-foto',         'ChefController@postAlterarFotoPerfil');
        Route::post('alterar-dados',        'ChefController@postAlterarDados');
        Route::post('alterar-localizacao',  'ChefController@postAlterarLocalizacao');
        Route::post('conta-bancaria/novo',  'ChefController@postSalvarDadosBancarios')->name('chef.dados_bancarios.novo_salvar');
        Route::post('conta-bancaria/editar/{id}', 'ChefController@postAtualizarDadosBancarios')->name('chef.dados_bancarios.editar_salvar');

        Route::group(['prefix' => 'reservas'], function() {

            Route::get('/', 'ChefController@getListarReservas')->name("chef.reserva.listar");
            Route::get('detalhes/{reserva}', 'ChefController@getReservaDetalhes')->name('chef.reserva.detalhes');

        });


        Route::group(['prefix' => 'menu'], function() {

            Route::get('listar',                   'MenuController@getListagemMenus')->name('menus.listar');
            Route::get('novo',                     'MenuController@getNovoMenu')->name('menus.novo_menu');
            Route::get('editar/{id}',              'MenuController@getEditarMenu');
            Route::get('ativar/{id}',              'MenuController@getAtivarMenu')->name('ativar-menu');
            Route::get('inativar/{id}',            'MenuController@getInativarMenu')->name('inativar-menu');
            Route::get('{menu}/deletar-foto/{id}', 'MenuController@getDeletarFotoMenu')->name('menu.deletar_foto');
            Route::get('{menu}/definir-capa/{id}', 'MenuController@getDefinirComoCapa')->name('menu.definir_capa');
            Route::post('salvar',                  'MenuController@postSalvar')->name('salvar-menu');

        });

        Route::group(['prefix' => 'cursos'], function() {

            Route::get('listar',                    'CursoController@getListagemCursos')->name('cursos.listar');
            Route::get('novo',                      'CursoController@getNovoCurso')->name('cursos.novo_curso');
            Route::get('editar/{id}',               'CursoController@getEditarCurso');
            Route::get('ativar/{id}',               'CursoController@getAtivarCurso')->name('ativar-curso');
            Route::get('inativar/{id}',             'CursoController@getInativarCurso')->name('inativar-curso');
            Route::get('{curso}/deletar-foto/{id}', 'CursoController@getDeletarFotoCurso')->name('curso.deletar_foto');
            Route::get('{curso}/definir-capa/{id}', 'CursoController@getDefinirComoCapa')->name('curso.definir_capa');
            Route::post('salvar',                   'CursoController@postSalvar')->name('salvar-curso');

        });

        Route::group(['prefix' => 'saques'], function() {

            Route::get('/',           'SaqueController@getListar')->name('saque.listar');
            Route::get('/solicitar',  'SaqueController@getSolicitarSaque')->name('saque.solicitar');
            Route::post('/solicitar', 'SaqueController@postSolicitarSaque')->name('saque.realizar_saque');

        });

    });

    Route::group(['prefix' => 'reservar'], function() {
        Route::get('endereco/{chef}/{tipo}/{slug}',  'ReservaController@getEnderecoReserva')->name('reservar.endereco');
        Route::get('pagamento/{chef}/{tipo}/{slug}', 'ReservaController@getPagamento')->name('reservar.pagamento');
        Route::get('sucesso/{reserva}',              'ReservaController@getReservaFinalizada')->name('reservar.sucesso');
        Route::get('reprovado/{reserva}',            'ReservaController@getReservaReprovada')->name('reservar.reprovado');
        Route::post('finalizar',                     'ReservaController@postFinalizarReserva')->name('reservar.finalizar');
    });

    Route::get('facebook/login',          'FacebookController@login');
    Route::get('facebook/login/callback', 'FacebookController@callback');

    Route::post('login',        'Auth\AuthController@postLogin');
    Route::post('registrar',    'Auth\AuthController@postCadastrar');
    Route::get('logout',        'Auth\AuthController@getLogout');

    Route::post('newsletter', function() {
        session()->flash('sweet_alert', [
            'title'   => 'Sucesso!',
            'message' => "Você se cadastrou com sucesso no nosso newsletter.",
            'type'    => "success"
        ]);
        return redirect()->back();
    });

});