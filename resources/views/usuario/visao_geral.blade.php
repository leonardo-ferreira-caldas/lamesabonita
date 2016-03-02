@extends('template')

@section('after-header')
<!-- Page Title
============================================= -->
<section id="page-title" class="page-title-center">

    <div class="container clearfix">
        <h1><span>Minha Conta</span></h1>
    </div>

</section><!-- #page-title end -->
@endsection

@section('content')
<div class="container inner-pages">
    <div class="col_one_fourth">
        @include('usuario.sidebar')
    </div>
    <div class="col_three_fourth col_last backgroundWhite">
        <div class="fancy-title title-bottom-border">
            <h2>Visão Geral</h2>
        </div>
        <div class="my-profile">
            <div class="col_half">
                <div class="fancy-title title-dotted-border title-left marginbottom10px">
                    <h3>Informações Pessoais</h3>
                </div>
                <ul>
                    <li><div class="col_half bottommargin-sm"><span>Nome</span></div><div class="col_half col_last bottommargin-xsm">{{ $auth->getName() }}</div></li>
                    <li><div class="col_half bottommargin-sm"><span>Email</span></div><div class="col_half col_last bottommargin-xsm breakword">{{ $auth->getEmail() }}</div></li>
                    <li><div class="col_half bottommargin-sm"><span>CPF</span></div><div class="col_half col_last bottommargin-xsm">{{ $auth->getDegustador('cpf') }}</div></li>
                    <li><div class="col_half bottommargin-sm"><span>Telefone</span></div><div class="col_half col_last bottommargin-xsm">{{ $auth->getDegustador('telefone') }}</div></li>
                </ul>
            </div>
            <div class="col_half col_last">
                <div class="fancy-title title-dotted-border title-left marginbottom10px">
                    <h3>Endereço</h3>
                </div>
                <ul>
                    <li>
                        <div class="col_half bottommargin-sm"><span>CEP</span></div>
                        <div class="col_half col_last bottommargin-xsm">{{ $auth->getDegustadorEndereco('cep') ?: 'Não Cadastrado' }}</div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Rua/Número</span></div>
                        <div class="col_half col_last bottommargin-xsm">
                            @if($auth->hasDegustadorEndereco())
                                {{ $auth->getDegustadorEndereco('logradouro') }}, {{ $auth->getDegustadorEndereco('logradouro_numero') }}
                            @else
                                Não cadastrado
                            @endif
                        </div>
                    </li>
                    <li><div class="col_half bottommargin-sm"><span>Bairro</span></div><div class="col_half col_last bottommargin-xsm">{{ $auth->getDegustadorEndereco('bairro') ?: 'Não Cadastrado' }}</div></li>
                    <li><div class="col_half bottommargin-sm"><span>Cidade</span></div><div class="col_half col_last bottommargin-xsm">{{ $auth->getNomeCidade() ?: 'Não Cadastrado' }}</div></li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Estado - País</span></div>
                        <div class="col_half col_last bottommargin-xsm">
                            @if($auth->hasDegustadorEndereco())
                                {{ $auth->getNomeEstado() }} - {{ $auth->getNomePais() }}
                            @else
                                Não cadastrado
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
            <div class="divider divider-center nomargin"><i class="fa fa-cutlery"></i></div>
            <p class="notopmargin topmargin-xsm">Gostaria de receber notícias e promoções? Se inscreva agora mesmo no nosso newsletter!</p>
            <div class="check-box">        
                <input type="checkbox" {{ $newsletter ? 'checked' : '' }} class='checkbox' id="newsletter-check">
                <label for="newsletter-check" class='checkbox' id="label-newsletter-check">Sim, eu gostaria de receber ofertas especiais e promoções do La Mesa Bonita!</label>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $("#newsletter-check").click(function() {
            location.href = '{{ route('degustador.newsletter') }}';
        });
    });
</script>
@endsection