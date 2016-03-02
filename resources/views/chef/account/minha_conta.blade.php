@extends('template')

@include('chef.account.foto_capa')

@section('content')
<div class="mb-container">
    <div class="container inner-pages mb-nomargin mb-nopadding mb-nowidth">
        <div class="col_one_fourth">
            @include('chef.account.menu_lateral')
        </div>
        <div class="col_three_fourth col_last backgroundWhite mb-noborder mb-leftpadding-xsm mb-rightpadding-xsm mb-nobottomargin">
            <div class="fancy-title title-bottom-border">
                <h2>Visão Geral</h2>
                @if ($solicitou_aprovacao_perfil)
                    <a href="{{ route('solicitar-aprovacao-perfil') }}" class="btn-fancy-title button button-3d button-green nomargin"><i class="fa fa-check-square-o"></i> SOLICITAR APROVAÇÃO PERFIL</a>
                @endif
            </div>

            @if(session()->has('pendencias'))
                <div class="style-msg2 errormsg">
                    <div class="msgtitle">Você não terminou de preencher seu perfil. Complete a lista abaixo:</div>
                    <div class="sb-msg">
                        <ul>
                            @foreach(session('pendencias') as $pendencia)
                                <li>{{ $pendencia }}</div></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @else

                @if ($solicitou_aprovacao_perfil)
                    <div class="style-msg alertmsg">
                        <div class="sb-msg"><i class="fa fa-info-circle"></i><strong>Informação:</strong> Para <strong>ativar</strong> seu perfil, complete todos os passos listados abaixo.</div>
                    </div>
                @elseif($perfil_em_analise)
                    <div class="style-msg infomsg">
                        <div class="sb-msg"><i class="icon-info-sign"></i><strong>Informação:</strong> Você solicitou a aprovação do seu perfil como chef. Aguarde enquanto nossa equipe analisa seu perfil.</div>
                    </div>
                @elseif($perfil_reprovado)
                    <div class="style-msg errormsg">
                        <div class="sb-msg"><i class="icon-remove"></i><strong>Informação:</strong> O seu perfil foi reprovado por nossa equipe. Entre em contato para mais informações.</div>
                    </div>
                @endif

            @endif

            <div class="fancy-title title-dotted-border title-left marginbottom10px">
                <h4>Minhas <span>Informações</span></h4>
            </div>

            @if(empty($dados))

                <h4 class='title-ativando-conta mb-bottommargin-xxsm'>Você ainda não preencheu suas informações pessoais.</h4>
                <a href="{{ route('chef.informacoes_pessoais') }}" class="mb-bottommargin-xsm button button-3d button-small nomargin"><i class="fa fa-user"></i> Cadastrar Informações</a>

            @else

                <div class="col_half my-profile bottommargin-sm">

                    <ul>
                        <li><div class="col_half bottommargin-sm"><span>Nome:</span></div> <div class="col_half col_last bottommargin-xsm">{{ $dados['nome_completo'] }}</div></li>
                        <li><div class="col_half bottommargin-sm"><span>Email:</span></div> <div class="col_half col_last bottommargin-xsm breakword">{{ $dados['email'] }}</div></li>
                        <li><div class="col_half bottommargin-sm"><span>Sexo:</span></div> <div class="col_half col_last bottommargin-xsm">{{ $dados['sexo_descricao'] }}</div></li>
                    </ul>

                </div>

                <div class="col_half my-profile col_last bottommargin-sm">

                    <ul>
                        <li><div class="col_half bottommargin-sm"><span>Telefone:</span></div> <div class="col_half col_last bottommargin-xsm">{{ $dados['telefone'] }}</div></li>
                        <li><div class="col_half bottommargin-sm"><span>Data de Nascimento:</span></div> <div class="col_half col_last bottommargin-xsm">{{ $dados['data_nascimento'] }}</div></li>
                    </ul>

                </div>

                <div class="clear"></div>

                <a href="{{ route('chef.informacoes_pessoais') }}" class="mb-bottommargin-xsm button button-3d button-small nomargin"><i class="fa fa-user"></i> Editar Informações</a>

            @endif

            <div class="clear"></div>

            <div class="margintop30px fancy-title title-dotted-border title-left marginbottom10px">
                <h4>Minha <span>Localização</span></h4>
            </div>

            <div class="col_half my-profile bottommargin-sm">

                <ul>
                    <li><div class="col_half bottommargin-sm"><span>País:</span></div> <div class="col_half col_last bottommargin-xsm">{{ $dados['pais'] }}</div></li>
                    <li><div class="col_half bottommargin-sm"><span>Estado:</span></div> <div class="col_half col_last bottommargin-xsm">{{ $dados['estado'] }}</div></li>
                    <li><div class="col_half bottommargin-sm"><span>Cidade:</span></div> <div class="col_half col_last bottommargin-xsm">{{ $dados['cidade'] }}</div></li>
                </ul>

            </div>

            <div class="col_half my-profile col_last bottommargin-sm">

                <ul>
                    <li><div class="col_half bottommargin-sm"><span>Endereço:</span></div> <div class="col_half col_last bottommargin-xsm">{{ $dados['logradouro'] }}, {{ $dados['logradouro_numero'] }}</div></li>
                    <li><div class="col_half bottommargin-sm"><span>CEP:</span></div> <div class="col_half col_last bottommargin-xsm">{{ $dados['cep'] }}</div></li>

                </ul>

            </div>

            <div class="clear"></div>

            <a href="{{ route('chef.localizacao') }}" class="mb-bottommargin-xsm button button-3d button-small nomargin"><i class="fa fa-user"></i> Editar Minha Localização</a>

            <div class="clear"></div>

            <div class="margintop30px fancy-title title-dotted-border title-left">
                <h4>Meus <span>Menus</span></h4>
            </div>

            @if($quantidade_menus == 0)

                <h4 class='title-ativando-conta mb-bottommargin-xxsm'>Você ainda não cadastrou menus.</h4>
                <a href="{{ route('menus.novo_menu') }}" class="mb-bottommargin-xsm button button-3d button-small nomargin"><i class="fa fa-cutlery"></i> Cadastrar Menu</a>

            @else

                @if ($quantidade_menus == 1)
                    <h4 class='title-ativando-conta'>Você possui 1 menu cadastrado.</h4>
                @else
                    <h4 class='title-ativando-conta'>Você possui {{ $quantidade_menus }} menus cadastrados.</h4>
                @endif

                <a href="{{ route('menus.listar') }}" class="mb-bottommargin-xsm button button-3d button-small nomargin"><i class="fa fa-cutlery"></i> Ver Meus Menus</a>

            @endif

            <div class="clear"></div>

            <div class="margintop30px fancy-title title-dotted-border title-left">
                <h4>Meus <span>Cursos</span></h4>
            </div>

            @if($quantidade_cursos == 0)

                <h4 class='title-ativando-conta mb-bottommargin-xxsm'>Você ainda não cadastrou cursos.</h4>
                <a href="{{ route('cursos.novo_curso') }}" class="mb-bottommargin-xsm button button-3d button-small nomargin"><i class="fa fa-cutlery"></i> Cadastrar Curso</a>

            @else

                @if ($quantidade_cursos == 1)
                    <h4 class='title-ativando-conta'>Você possui 1 curso cadastrado.</h4>
                @else
                    <h4 class='title-ativando-conta'>Você possui {{ $quantidade_cursos }} cursos cadastrados.</h4>
                @endif

                <a href="{{ route('cursos.listar') }}" class="mb-bottommargin-xsm button button-3d button-small nomargin"><i class="fa fa-cutlery"></i> Ver Meus Cursos</a>

            @endif

            <div class="clear"></div>

            <div class="margintop30px fancy-title title-dotted-border title-left marginbottom10px">
                <h4>Dados <span>Bancários</span></h4>
            </div>

            @if(count($quantidade_contas_bancarias) == 0)

                <h4 class='title-ativando-conta mb-bottommargin-xxsm'>Você não cadastrou a conta que gostaria de receber suas reservas.</h4>
                <a href="{{ route('chef.dados_bancarios') }}" class="button button-3d button-small nomargin"><i class="fa fa-university"></i> Cadastrar Dados Bancários</a>

            @else

                @if ($quantidade_contas_bancarias == 1)
                    <h4 class='title-ativando-conta'>Você possui 1 conta bancária cadastrada.</h4>
                @else
                    <h4 class='title-ativando-conta'>Você possui {{ $quantidade_contas_bancarias }} contas bancárias cadastradas.</h4>
                @endif

                <div class="clear"></div>

                <a href="{{ route('chef.dados_bancarios') }}" class="button button-3d button-small nomargin"><i class="fa fa-user"></i> Ver Minhas Contas Bancárias</a>

            @endif


        </div>
    </div>
</div>
@endsection