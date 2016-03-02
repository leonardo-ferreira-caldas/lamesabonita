@extends('template')

@section('page-title')
<div class="pm-sub-header-title-container">
    <p class="pm-sub-header-title">
        <span class="playball">Minha Conta</span>
    </p>
</div>
@endsection

@section('content')
<div class="container inner-pages">
    <div class='row'>
        <div class='col-md-12'>
            <ol class="breadcrumb">
                  <li><a href="/"><i class="fa fa-home"></i></a></li>
                  <li><a href="/chefs/">Minha Conta</a></li>
                  <li class="active">Detalhes da Conta</li>
            </ol>
        </div>
    </div>
    <div class='row'>
        <div class="col-md-3">
            @include('usuario.sidebar')
        </div>
        <div class="col-md-9 credit-cards">
            <h2 class="title">Meus Cartões</h2>
            <div class="row row-wrap">
                <div class="col-md-4">
                    <div class="card-thumb">
                        <ul class="card-thumb-actions">
                            <li>
                                <a class="fa fa-pencil popup-text" href="#edit-card-dialog" rel="tooltip" data-placement="top" title="" data-effect="mfp-zoom-out" data-original-title="edit"></a>
                            </li>
                            <li>
                                <a class="fa fa-times" href="#" rel="tooltip" data-placement="top" title="" data-original-title="remove"></a>
                            </li>
                        </ul>
                        <p class="card-thumb-number">XXXX XXX XXXX 5622</p>
                        <p class="card-thumb-valid">Válido Até <span>8 / 18</span>
                        </p>
                        <img class="card-thumb-type" src="/img/cartoes/mastercard-curved-32px.png" alt="Image Alternative text" title="Image Title"><small>Proprietário Cartão</small>
                        <h5 class="uc">Leonardo Caldas</h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-thumb card-thumb-primary"><span class="card-thumb-primary-label">principal</span>
                        <ul class="card-thumb-actions">
                            <li>
                                <a class="fa fa-pencil popup-text" href="#edit-card-dialog" rel="tooltip" data-placement="top" title="" data-effect="mfp-zoom-out" data-original-title="edit"></a>
                            </li>
                            <li>
                                <a class="fa fa-times" href="#" rel="tooltip" data-placement="top" title="" data-original-title="remove"></a>
                            </li>
                        </ul>
                        <p class="card-thumb-number">XXXX XXX XXXX 9923</p>
                        <p class="card-thumb-valid">Válido Até <span>12 / 16</span>
                        </p>
                        <img class="card-thumb-type" src="/img/cartoes/mastercard-curved-32px.png" alt="Image Alternative text" title="Image Title"><small>Proprietário Cartão</small>
                        <h5 class="uc">Leonardo Caldas</h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-thumb">
                        <ul class="card-thumb-actions">
                            <li>
                                <a class="fa fa-pencil popup-text" href="#edit-card-dialog" rel="tooltip" data-placement="top" title="" data-effect="mfp-zoom-out" data-original-title="edit"></a>
                            </li>
                            <li>
                                <a class="fa fa-times" href="#" rel="tooltip" data-placement="top" title="" data-original-title="remove"></a>
                            </li>
                        </ul>
                        <p class="card-thumb-number">XXXX XXX XXXX 4335</p>
                        <p class="card-thumb-valid">Válido Até <span>6 / 15</span>
                        </p>
                        <img class="card-thumb-type" src="/img/cartoes/american-express-curved-32px.png" alt="Image Alternative text" title="Image Title"><small>Proprietário Cartão</small>
                        <h5 class="uc">Leonardo Caldas</h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-thumb">
                        <ul class="card-thumb-actions">
                            <li>
                                <a class="fa fa-pencil popup-text" href="#edit-card-dialog" rel="tooltip" data-placement="top" title="" data-effect="mfp-zoom-out" data-original-title="edit"></a>
                            </li>
                            <li>
                                <a class="fa fa-times" href="#" rel="tooltip" data-placement="top" title="" data-original-title="remove"></a>
                            </li>
                        </ul>
                        <p class="card-thumb-number">XXXX XXX XXXX 1547</p>
                        <p class="card-thumb-valid">Válido Até <span>11 / 18</span>
                        </p>
                        <img class="card-thumb-type" src="/img/cartoes/visa-curved-32px.png" alt="Image Alternative text" title="Image Title"><small>Proprietário Cartão</small>
                        <h5 class="uc">Leonardo Caldas</h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-thumb">
                        <ul class="card-thumb-actions">
                            <li>
                                <a class="fa fa-pencil popup-text" href="#edit-card-dialog" rel="tooltip" data-placement="top" title="" data-effect="mfp-zoom-out" data-original-title="edit"></a>
                            </li>
                            <li>
                                <a class="fa fa-times" href="#" rel="tooltip" data-placement="top" title="" data-original-title="remove"></a>
                            </li>
                        </ul>
                        <p class="card-thumb-number">XXXX XXX XXXX 9348</p>
                        <p class="card-thumb-valid">Válido Até <span>8 / 16</span>
                        </p>
                        <img class="card-thumb-type" src="/img/cartoes/american-express-curved-32px.png" alt="Image Alternative text" title="Image Title"><small>Proprietário Cartão</small>
                        <h5 class="uc">Leonardo Caldas</h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-thumb popup-text" href="#new-card-dialog" data-effect="mfp-zoom-out">
                        <i class="fa fa-plus card-thumb-new"></i>
                        <p>Adicionar<br>Novo Cartão</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection