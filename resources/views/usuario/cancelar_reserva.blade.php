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
    <div class="col_three_fourth marginbottom10px col_last backgroundWhite">
        <div class="fancy-title title-bottom-border">
            <h2>Cancelar Reserva</h2>
        </div>

        <p>Nosso principal valor é a confiança. Todos os chefs parceiros La Mesa Bonita são indicados por outros profissionais de nossa confiança, o que garante a qualidade do seu trabalho e sua idoneidade. Os clientes confiam que todos os profissionais que encontrarem na nossa lista de chefs tornarão sua noite inesquecível.</p>

        <p>Para garantir o merecido reconhecimento para os chefs que se destacam entre tantos talentos, nós desenvolvemos o Selo La Mesa Bonita. Trata-se de um certificado concedido aos chefs que são avaliados por seu desempenho e pela garantia de que o valor dos seus menus está de acordo com seu nível de qualidade e conhecimento oferecidos.</p>

        <p>O Selo LMB é concedido após um evento teste, no qual o chef cozinha para o júri La Mesa Bonita, composto por um grupo de oito especialistas. São membros da nossa equipe, especialistas da indústria (críticos, bloggers e staff de restaurantes), outros chefs e jornalistas. Após o jantar, cada membro do júri dá a sua opinião, ao preencher um criterioso questionário de avaliação. É com base nessas avaliações que decidimos sobre a certificação ou não do candidato. Os chefs certificados têm o selo La Mesa Bonita visível nos seus perfis e menus. Para os chefs, é uma oportunidade de destacar-se. Os clientes podem confiar de olhos fechados nos chefs parceiros La Mesa Bonita que possuam o Selo LMB.</p>

        <p>Queremos sempre ser merecedores da confiança depositada em nós, e não medimos esforços para atingir este objetivo.</p>

        <a href="{{ route('degustador.executar_cancelamento_reserva', ['reserva' => $id_reserva]) }}" class="button button-3d button-red nomargin">
            ACEITO CANCELAR MINHA RESERVA
        </a>

        <a href="{{ route('degustador.reservas') }}" class="button button-3d nomargin">
            NÃO QUERO CANCELAR
        </a>



    </div>
</div>
@endsection