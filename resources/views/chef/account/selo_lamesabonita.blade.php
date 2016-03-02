@extends('template')

@include('chef.account.foto_capa')

@section('content')
<div class="container inner-pages mb-nomargin mb-nopadding mb-nowidth">
    <div class="col_one_fourth">
        @include('chef.account.menu_lateral')
    </div>
    <div class="col_three_fourth marginbottom10px col_last backgroundWhite mb-noborder mb-leftpadding-xsm mb-rightpadding-xsm mb-nobottomargin">
        <div class="fancy-title title-bottom-border">
            <h2>Selo La Mesa Bonita</h2>
        </div>

        <p>Nosso principal valor é a confiança. Todos os chefs parceiros La Mesa Bonita são indicados por outros profissionais de nossa confiança, o que garante a qualidade do seu trabalho e sua idoneidade. Os clientes confiam que todos os profissionais que encontrarem na nossa lista de chefs tornarão sua noite inesquecível.</p>

        <p>Para garantir o merecido reconhecimento para os chefs que se destacam entre tantos talentos, nós desenvolvemos o Selo La Mesa Bonita. Trata-se de um certificado concedido aos chefs que são avaliados por seu desempenho e pela garantia de que o valor dos seus menus está de acordo com seu nível de qualidade e conhecimento oferecidos.</p>

        <p>O Selo LMB é concedido após um evento teste, no qual o chef cozinha para o júri La Mesa Bonita, composto por um grupo de oito especialistas. São membros da nossa equipe, especialistas da indústria (críticos, bloggers e staff de restaurantes), outros chefs e jornalistas. Após o jantar, cada membro do júri dá a sua opinião, ao preencher um criterioso questionário de avaliação. É com base nessas avaliações que decidimos sobre a certificação ou não do candidato. Os chefs certificados têm o selo La Mesa Bonita visível nos seus perfis e menus. Para os chefs, é uma oportunidade de destacar-se. Os clientes podem confiar de olhos fechados nos chefs parceiros La Mesa Bonita que possuam o Selo LMB.</p>

        <p>Queremos sempre ser merecedores da confiança depositada em nós, e não medimos esforços para atingir este objetivo.</p>

        @if($solicitou_selo)
            <div class="style-msg successmsg">
                <div class="sb-msg"><i class="icon-thumbs-up"></i><strong>Sucesso!</strong> Você solicitou o selo La Mesa Bonita. Aguarde o contato da nossa equipe.</div>
            </div>
        @else
            <a href="{{ route('solicitacao-selo') }}" class="mb-button-full mb-nopadding text-center button button-3d button-green nomargin">
                <i class="fa fa-diamond"></i> Solicitar Selo La Mesa Bonita
            </a>
        @endif
        

    </div>
</div>
@endsection