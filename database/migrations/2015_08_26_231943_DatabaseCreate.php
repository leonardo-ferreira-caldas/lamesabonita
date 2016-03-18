<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DatabaseCreate extends Migration
{

    private function createChefTable() {
        Schema::create('chef_status', function (Blueprint $table) {
            $table->increments('id_chef_status');
            $table->string('descricao', 100);
        });

        Schema::create('chef_selo_status', function (Blueprint $table) {
            $table->increments('id_selo_status');
            $table->string("descricao", 100);
        });

        Schema::create('chef', function (Blueprint $table) {
            $table->unsignedInteger('id_chef');
            $table->unsignedInteger('fk_sexo')->nullable();
            $table->unsignedInteger('fk_status');
            $table->unsignedInteger('fk_selo_status')->nullable();
            $table->unsignedInteger('fk_cidade')->nullable();
            $table->char('fk_estado', 4)->nullable();
            $table->char('fk_pais')->index()->nullable();

            $table->decimal("saldo", 9, 2);
            $table->date("data_nascimento");

            $table->longtext('sobre_chef')->nullable();
            $table->string("sobrenome", 50);
            $table->string("cpf", 14);
            $table->string("rg", 20);
            $table->string("avatar", 100)->nullable();
            $table->string("slug", 120)->unique();
            $table->string("telefone", 20)->nullable();
            $table->string("foto_capa", 100)->nullable();

            $table->string("cep", "20");
            $table->string('logradouro', '100');
            $table->string('logradouro_numero', '10');
            $table->string('bairro', '60');

            $table->boolean('ind_toda_cidade')->nullable();

            $table->integer('distancia_aceita')->nullable();

            $table->string('moip_id', 30);
            $table->string('moip_access_token', 30);
            $table->string('moip_login', 30);
            $table->string('moip_created_at', 30);

            $table->foreign('fk_sexo')->references('id_sexo')->on('sexo');
            $table->foreign('fk_selo_status')->references('id_selo_status')->on('chef_selo_status');
            $table->foreign('fk_status')->references('id_chef_status')->on('chef_status');
            $table->foreign('fk_cidade')->references('id_cidade')->on('cidade');
            $table->foreign('fk_estado')->references('id_estado')->on('estado'); 
            $table->foreign('fk_pais')->references('id_pais')->on('pais');
            $table->foreign('id_chef')->references('id')->on('users');
            
            $table->timestamps();
        });

        Schema::create('chef_conta_bancaria', function (Blueprint $table) {
            $table->increments('id_conta_bancaria');
            $table->unsignedInteger('fk_chef');
            $table->unsignedInteger('fk_banco');
            $table->string('banco_agencia', 10);
            $table->tinyInteger('banco_agencia_digito');
            $table->string('banco_conta', 10);
            $table->tinyInteger('banco_conta_digito');
            $table->string('banco_proprietario_conta', 100);
            $table->string('moip_id', 30)->nullable();
            $table->string('moip_status', 30)->nullable();

            $table->foreign('fk_chef')->references('id_chef')->on('chef');
            $table->timestamps();
        });

        Schema::create('chef_agenda', function (Blueprint $table) {
            $table->increments('id_chef_agenda');
            $table->unsignedInteger('fk_chef');
            $table->date('data');
            $table->time('hora_de');
            $table->time('hora_ate');

            $table->foreign('fk_chef')->references('id_chef')->on('chef');
            $table->unique(['fk_chef', 'data']);
            $table->softDeletes();
            $table->timestamps();
        });

    }

    private function createSaque() {

        Schema::create('saque_status', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->increments('id_saque_status');
            $table->string("descricao", 100);
        });

        Schema::create('saque', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->increments('id_saque');
            $table->unsignedInteger('fk_chef');
            $table->unsignedInteger('fk_conta_bancaria');
            $table->unsignedInteger('fk_saque_status');
            $table->decimal("valor_saque", 9, 2);
            $table->decimal("valor_taxa", 9, 2);
            $table->string('moip_id', 30)->nullable();
            $table->string('moip_status', 30)->nullable();

            $table->foreign('fk_chef')->references('id_chef')->on('chef');
            $table->foreign('fk_conta_bancaria')->references('id_conta_bancaria')->on('chef_conta_bancaria');
            $table->foreign('fk_saque_status')->references('id_saque_status')->on('saque_status');
            $table->timestamps();
        });

    }

    private function createUserTable() {

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('password', 60);
            $table->string('email')->unique();
            $table->boolean('ind_chef');
            $table->boolean('ind_email_confirmado');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });

    }

    private function createDegustadorTable() {

        Schema::create('degustador', function (Blueprint $table) {
            $table->integer('id_degustador')->unsigned();
            $table->integer('fk_sexo')->unsigned()->nullable();
            $table->string("cpf", "15")->nullable();
            $table->string("telefone", "20")->nullable();
            $table->string("avatar", "100");
            $table->boolean("ind_newsletter")->default(0);

            $table->timestamps();

            $table->foreign('fk_sexo')->references('id_sexo')->on('sexo');
            $table->foreign('id_degustador')->references('id')->on('users');
        });


        Schema::create('degustador_endereco', function (Blueprint $table) {
            $table->increments('id_degustador_endereco');
            $table->string('descricao', 100);
            $table->integer('fk_degustador')->unsigned();
            $table->integer('fk_cidade')->unsigned();
            $table->char('fk_estado', 4);
            $table->char('fk_pais')->index();
            $table->smallInteger('ind_endereco_principal')->unsigned();
            $table->string("cep", "20");
            $table->string('logradouro', '100');
            $table->string('logradouro_numero', '10');
            $table->string('bairro', 100);
            $table->longText('complemento');

            $table->foreign('fk_degustador')->references('id_degustador')->on('degustador');
            $table->foreign('fk_cidade')->references('id_cidade')->on('cidade'); 
            $table->foreign('fk_estado')->references('id_estado')->on('estado'); 
            $table->foreign('fk_pais')->references('id_pais')->on('pais');
            
            $table->timestamps();
        });

    }

    private function createGeographicTables() {

        Schema::create('pais', function (Blueprint $table) {
            $table->char('id_pais');
            $table->primary('id_pais');
            $table->string("nome_pais", 100);
            $table->timestamps();
        });

        Schema::create('estado', function (Blueprint $table) {
            $table->char('id_estado', 4);
            $table->primary('id_estado');
            $table->string("nome_estado", 60);
            $table->char("fk_pais")->index();

            $table->foreign('fk_pais')->references('id_pais')->on('pais');

            $table->timestamps();
        });

        Schema::create('cidade', function (Blueprint $table) {
            $table->increments('id_cidade');
            $table->char('fk_estado', 4);
            $table->string("nome_cidade", 100);

            $table->foreign('fk_estado')->references('id_estado')->on('estado'); 

            $table->timestamps();
        });

    }

    private function createavaliacaoTable() {

        Schema::create('avaliacao', function (Blueprint $table) {
            $table->increments('id_avaliacao');
            $table->longtext('texto');
            $table->decimal('nota', 3, 1);
            $table->integer("fk_degustador")->unsigned();
            $table->integer("fk_chef")->unsigned();
            $table->smallInteger("ind_aguardando_aprovacao")->default(0);

            $table->foreign('fk_chef')->references('id_chef')->on('chef'); 
            $table->foreign('fk_degustador')->references('id_degustador')->on('degustador'); 

            $table->timestamps();
        });

    }

    private function createDiscretInformationTables() {

        Schema::create('culinaria', function (Blueprint $table) {
            $table->increments('id_culinaria');
            $table->string("nome_culinaria", 100);
            $table->timestamps();
        });

        Schema::create('banco', function (Blueprint $table) {
            $table->char('id_banco');
            $table->string("nome_banco", 100);
        });

        Schema::create('sexo', function (Blueprint $table) {
            $table->increments('id_sexo');
            $table->string("descricao", 20);
        });

    }

    private function createreservaTables() {

        Schema::create('reserva_status', function (Blueprint $table) {
            $table->increments('id_reserva_status');
            $table->string('nome_status', 60);
        });

        Schema::create('reserva', function (Blueprint $table) {
            $table->increments('id_reserva');
            $table->integer('fk_degustador')->unsigned();
            $table->integer('fk_degustador_endereco')->unsigned();
            $table->integer('fk_chef')->unsigned();
            $table->integer('fk_menu')->unsigned()->nullable();
            $table->integer('fk_curso')->unsigned()->nullable();
            $table->integer('fk_status')->unsigned();
            $table->date('data_reserva');
            $table->time('horario_reserva');
            $table->integer('qtd_clientes')->unsigned();
            $table->decimal('preco_por_cliente', 8, 2);
            $table->decimal('taxa_lmb', 5, 2);
            $table->decimal('preco_total', 10, 2);
            $table->decimal('porcentagem_chef', 3, 1);
            $table->decimal('vlr_divisao_chef', 10, 2);
            $table->decimal('vlr_divisao_lmb', 10, 2);
            $table->text('observacao')->nullable();

            $table->foreign('fk_degustador')->references('id_degustador')->on('degustador');
            $table->foreign('fk_degustador_endereco')->references('id_degustador_endereco')->on('degustador_endereco');
            $table->foreign('fk_chef')->references('id_chef')->on('chef');
            $table->foreign('fk_menu')->references('id_menu')->on('menu');
            $table->foreign('fk_status')->references('id_reserva_status')->on('reserva_status');

            $table->timestamps();
        });

    }

    private function createpagamentoTable() {

        Schema::create('pagamento_metodo', function (Blueprint $table) {
            $table->increments('id_pagamento_metodo');
            $table->string('nome_pagamento_metodo', 100);
        });

        Schema::create('pagamento_status', function (Blueprint $table) {
            $table->increments('id_pagamento_status');
            $table->string('nome_pagamento_status', 100);
        });

        Schema::create('pagamento', function (Blueprint $table) {
            $table->increments('id_pagamento');
            $table->integer('fk_reserva')->unsigned();
            $table->integer('fk_pagamento_metodo')->unsigned();
            $table->integer('fk_pagamento_status')->unsigned();

            $table->foreign('fk_reserva')->references('id_reserva')->on('reserva');
            $table->foreign('fk_pagamento_metodo')->references('id_pagamento_metodo')->on('pagamento_metodo');
            $table->foreign('fk_pagamento_status')->references('id_pagamento_status')->on('pagamento_status');

            $table->timestamps();
        });

        Schema::create('pagamento_taxa', function (Blueprint $table) {
            $table->increments('id_pagamento_taxa');
            $table->integer('fk_pagamento')->unsigned();
            $table->string('tipo', 35);
            $table->decimal('valor')->unsigned();

            $table->foreign('fk_pagamento')->references('id_pagamento')->on('pagamento');

            $table->timestamps();
        });

        Schema::create('pagamento_reembolso', function (Blueprint $table) {
            $table->increments('id_pagamento_reembolso');
            $table->integer('fk_pagamento')->unsigned();
            $table->string('moip_id', 35);
            $table->decimal('valor')->unsigned();

            $table->foreign('fk_pagamento')->references('id_pagamento')->on('pagamento');

            $table->timestamps();
        });

        Schema::create('pagamento_cartao', function (Blueprint $table) {
            $table->increments('id_pagamento_cartao');
            $table->integer('fk_pagamento')->unsigned();
            $table->string('moip_id', 30);
            $table->string('titular_cartao', 40);
            $table->string('numero_cartao', 18);
            $table->string('bandeira', 20);

            $table->foreign('fk_pagamento')->references('id_pagamento')->on('pagamento');

            $table->timestamps();
        });

        Schema::create('pagamento_tracking', function (Blueprint $table) {
            $table->increments('id_pagamento_tracking');
            $table->integer('fk_pagamento')->unsigned();
            $table->integer('fk_pagamento_status')->unsigned();
            $table->string('tracking_descricao', 50);
            $table->string('tracking_data', 50);

            $table->foreign('fk_pagamento')->references('id_pagamento')->on('pagamento');
            $table->foreign('fk_pagamento_status')->references('id_pagamento_status')->on('pagamento_status');

            $table->timestamps();
        });

    }

    private function createMenuTable() {

        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id_menu');
            $table->integer('fk_chef')->unsigned();
            $table->string('titulo', 80);
            $table->string("slug", 120)->unique();
            $table->longtext('aperitivo');
            $table->longtext('entrada');
            $table->longtext('prato_principal');
            $table->decimal('preco', 7, 2);
            $table->longtext('sobremesa');
            $table->boolean("ind_aguardando_aprovacao");
            $table->boolean("ind_ativo");
            $table->integer("qtd_maxima_cliente");

            $table->foreign('fk_chef')->references('id_chef')->on('chef');

            $table->timestamps();
        });

        Schema::create('menu_preco', function (Blueprint $table) {
            $table->increments('id_menu_preco');
            $table->integer('fk_menu')->unsigned();
            $table->integer('qtd_minima_clientes');
            $table->decimal('preco', 7, 2);
            $table->foreign('fk_menu')->references('id_menu')->on('menu');
            $table->timestamps();
        });

        Schema::create('menu_imagem', function (Blueprint $table) {
            $table->increments('id_menu_imagem');
            $table->integer('fk_menu')->unsigned();
            $table->string('nome_imagem', 150);
            $table->boolean('ind_capa');

            $table->foreign('fk_menu')->references('id_menu')->on('menu');
            $table->timestamps();
        });

    }

    private function createCursoTable() {

        Schema::create('curso', function (Blueprint $table) {
            $table->increments('id_curso');
            $table->integer('fk_chef')->unsigned();
            $table->string('titulo', 80);
            $table->string("slug", 120)->unique();
            $table->longtext("descricao");
            $table->decimal('preco', 7, 2);
            $table->boolean("ind_aguardando_aprovacao");
            $table->boolean("ind_ativo");
            $table->integer("qtd_maxima_cliente");

            $table->foreign('fk_chef')->references('id_chef')->on('chef');

            $table->timestamps();
        });

        Schema::create('curso_preco', function (Blueprint $table) {
            $table->increments('id_curso_preco');
            $table->integer('fk_curso')->unsigned();
            $table->integer('qtd_minima_clientes');
            $table->decimal('preco', 7, 2);
            $table->foreign('fk_curso')->references('id_curso')->on('curso');
            $table->timestamps();
        });

        Schema::create('curso_imagem', function (Blueprint $table) {
            $table->increments('id_curso_imagem');
            $table->integer('fk_curso')->unsigned();
            $table->string('nome_imagem', 150);
            $table->boolean('ind_capa');

            $table->foreign('fk_curso')->references('id_curso')->on('curso');
            $table->timestamps();
        });

    }

    private function favorito() {
        
        Schema::create('favorito', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->increments('id_favorito');
            $table->integer('fk_degustador')->unsigned();
            $table->integer('fk_menu')->unsigned()->nullable();
            $table->integer('fk_curso')->unsigned()->nullable();

            $table->timestamps();

            $table->foreign('fk_degustador')->references('id_degustador')->on('degustador');
            $table->foreign('fk_menu')->references('id_menu')->on('menu');
            $table->foreign('fk_curso')->references('id_curso')->on('curso');
        });

    }

    public function up() {
        $this->down();
        $this->createGeographicTables();
        $this->createDiscretInformationTables();
        $this->createUserTable();
        $this->createDegustadorTable();
        $this->createChefTable();
        $this->createCursoTable();
        $this->createMenuTable();
        $this->favorito();
        $this->createreservaTables();
        $this->createpagamentoTable();
        $this->createavaliacaoTable();
    }

    public function down() {
        Schema::dropIfExists('avaliacao');
        Schema::dropIfExists('favorito');
        Schema::dropIfExists('pagamento_tracking');
        Schema::dropIfExists('pagamento_cartao');
        Schema::dropIfExists('pagamento');
        Schema::dropIfExists('pagamento_status');
        Schema::dropIfExists('pagamento_metodo');
        Schema::dropIfExists('reserva');
        Schema::dropIfExists('reserva_status');
        Schema::dropIfExists('degustador_endereco');
        Schema::dropIfExists('degustador');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('menu_preco');
        Schema::dropIfExists('menu_imagem');
        Schema::dropIfExists('menu');
        Schema::dropIfExists('curso_preco');
        Schema::dropIfExists('curso_imagem');
        Schema::dropIfExists('curso');
        Schema::dropIfExists('chef_agenda');
        Schema::dropIfExists('chef_conta_bancaria');
        Schema::dropIfExists('chef');
        Schema::dropIfExists('chef_status');
        Schema::dropIfExists('chef_selo_status');
        Schema::dropIfExists('users');
        Schema::dropIfExists('cidade');
        Schema::dropIfExists('estado');
        Schema::dropIfExists('pais');
        Schema::dropIfExists('culinaria');
        Schema::dropIfExists('sexo');
        Schema::dropIfExists('banco');

    }
}
