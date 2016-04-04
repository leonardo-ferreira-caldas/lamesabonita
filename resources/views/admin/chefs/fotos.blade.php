@extends('admin.template.layout')

@section('content')


    <body class="ui_charcoal" data-page="projects:new">
    <header class="header-expanded navbar navbar-fixed-top navbar-gitlab">
        <div class="container-fluid">
            <div class="header-content">
                @include('admin.includes.topo_formulario')

                <h1 class="title">Alterar foto de perfil e capa</h1>
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
                              action="{{ route('backoffice.chef.alterar_foto_perfil', ['slug' => $slug]) }}"
                              enctype="multipart/form-data"
                              method="POST">

                            {!! csrf_field() !!}

                            <div class="form-group">

                                <div class="col-sm-3">
                                    <label class="block-label">Foto de Perfil</label>

                                    <div>
                                        <img src="{{ crop($foto_perfil, 150, 150) }}">
                                    </div>

                                    <div class="prepend-top-default"></div>

                                    <input type="file" name="foto_perfil">
                                </div>

                            </div>


                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-floppy-o rightmargin-xsm"></i> Alterar foto de perfil
                                </button>
                            </div>

                        </form>

                        <div class="prepend-top-default"></div>

                        <form class="form-horizontal topmargin"
                              action="{{ route('backoffice.chef.alterar_foto_capa', ['slug' => $slug]) }}"
                              enctype="multipart/form-data"
                              method="POST">

                            {!! csrf_field() !!}

                            <div class="form-group">

                                <div class="col-sm-12">
                                    <label class="block-label">Foto de Perfil</label>

                                    <div>
                                        <img src="{{ crop($foto_capa, 900, 200) }}">
                                    </div>

                                    <div class="prepend-top-default"></div>

                                    <input type="file" name="foto_capa">
                                </div>

                            </div>


                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-floppy-o rightmargin-xsm"></i> Alterar Foto de Capa
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/jquery.mask.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#data_nascimento").mask('99/99/9999');
            $("#telefone").mask('(99) 9999-9999?9');
            $("#cpf").mask('999.999.999-99');
            $("#cep").mask('99999-999');
            $("#fk_estado").change(function() {
                $("#fk_cidade").attr('readonly', true).html("<option value=''>Carregando...</option>");

                $.ajax({
                    url: '/backoffice/chef/buscar_cidade/' + $(this).val(),
                    method: 'GET',
                    dataType: 'json',
                    success: function(sucesso) {
                        $("#fk_cidade").attr('readonly', false).attr('disabled', false).html('');

                        for (var i in sucesso) {
                            $("#fk_cidade").append("<option value='" + sucesso[i].id_cidade + "'>" + sucesso[i].nome_cidade + "</option>");
                        }
                    }
                });

            });
        });
    </script>

@endsection
