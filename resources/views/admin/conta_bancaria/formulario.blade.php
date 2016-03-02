@extends('admin.template.layout')

@section('content')


    <body class="ui_charcoal" data-page="projects:new">
    <header class="header-expanded navbar navbar-fixed-top navbar-gitlab">
        <div class="container-fluid">
            <div class="header-content">
                @include('admin.includes.topo_formulario')
                <h1 class="title">Conta Bancária</h1>
            </div>
        </div>
    </header>
    <div class="page-sidebar-expanded page-with-sidebar">

        @include("admin.includes.menu")

        <div class="content-wrapper" id="tipo_culinaria">
            <div class="container-fluid container-limited">
                <div class="content">
                    <div class="clearfix">

                        <div class="prepend-top-default"></div>

                        <form class="form-horizontal"
                              action="{{ route('backoffice.conta_bancaria.salvar') }}"
                              accept-charset="UTF-8"
                              method="POST">

                            {!! csrf_field() !!}

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="id_tipo_refeicao">Código</label>
                                        <div class="col-sm-3">
                                            <input value="{{ $registro->id_conta_bancaria or '' }}" class="form-control" readonly="readonly"
                                                   type="text" name="id_conta_bancaria">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="fk_banco">Banco</label>
                                        <div class="col-sm-5">

                                            <select required name="fk_banco" class="form-control">
                                                @foreach($bancos as $banco)
                                                    <option
                                                        {{ $registro->fk_banco == $banco->id_banco ? 'selected' : '' }}
                                                        value="{{ $banco->id_banco }}">{{ $banco->id_banco . ' - ' . $banco->nome_banco}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="banco_proprietario_conta">Proprietário Conta</label>
                                        <div class="col-sm-5">
                                            <input required value="{{ $registro->banco_proprietario_conta }}" class="form-control"
                                                   type="text" name="banco_proprietario_conta">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="banco_agencia">Agência</label>
                                        <div class="col-sm-3">
                                            <input required value="{{ $registro->banco_agencia }}" class="form-control"
                                                   type="text" name="banco_agencia">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="banco_agencia_digito">Agência Digito</label>
                                        <div class="col-sm-3">
                                            <input value="{{ $registro->banco_agencia_digito }}" class="form-control"
                                                   type="text" name="banco_agencia_digito">
                                            <span class="help-block">Não obrigatório.</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="banco_conta">Conta</label>
                                        <div class="col-sm-3">
                                            <input required value="{{ $registro->banco_conta }}" class="form-control"
                                                   type="text" name="banco_conta">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="banco_conta_digito">Conta Digito</label>
                                        <div class="col-sm-3">
                                            <input required value="{{ $registro->banco_conta_digito }}" class="form-control"
                                                   type="text" name="banco_conta_digito">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="moip_id">Moip Id</label>
                                        <div class="col-sm-3">
                                            <input value="{{ $registro->moip_id }}" class="form-control" readonly
                                                   type="text" name="moip_id">
                                        </div>
                                    </div>

                                </div>

                            </div>


                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-floppy-o rightmargin-xsm"></i> Salvar
                                </button>

                                <a class="btn btn-cancel btn-gray" href="{{ route('backoffice.conta_bancaria.listar') }}">
                                    <i class="fa fa-list-alt rightmargin-xsm"></i> Voltar para a listagem
                                </a>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
