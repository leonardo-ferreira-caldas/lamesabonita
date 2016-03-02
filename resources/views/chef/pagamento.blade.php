@extends('template')

@include('chef.header')

@section('content')
<div class="container inner-pages">
    <div class='row'>
        <div class='col-md-12'>
            <ol class="breadcrumb">
                  <li><a href="/"><i class="fa fa-home"></i></a></li>
                  <li><a href="/chefs/">Minha Conta</a></li>
                  <li><a href="/chefs/">Chef</a></li>
                  <li class="active">Pagamento</li>
            </ol>
        </div>
    </div>

    @include('chef.top_menu')


    <div class='row'>
        <div class="col-md-12 visao-geral">
            
        </div>
    </div>
</div>
@endsection