@extends('admin.template.layout')

@section('content')
<body class='ui_charcoal login-page application navless'>

<div class='container navless-container'>
    <div class='content'>

        <div class='row'>
            <div class='col-sm-6 col-sm-offset-3'>
                <div>
                    <div class="center">
                        <img src="/images/logo@white.png" style="width: 70%" alt="La Mesa Bonita">
                    </div>
                    <br>
                    <div class='login-box'>
                        <div class='login-heading'>
                            <h3>Acessar Backoffice</h3>
                        </div>
                        <div class='login-body'>
                            <ul class='nav-links'>
                                <li class='active'>
                                    <a data-toggle="tab" href="#tab-signin">Entre com seu dados</a>
                                </li>
                            </ul>
                            <br>
                            <div class='tab-content'>
                                <div class='active tab-pane' id='tab-signin'>
                                    <form action="{{ route('admin.login.post') }}" accept-charset="UTF-8" method="POST">

                                        {!! csrf_field() !!}

                                        <input class="form-control top" placeholder="Usuário ou Email"
                                                autofocus="autofocus" autocapitalize="off" autocorrect="off" type="text"
                                                name="email"/>

                                        <input class="form-control bottom" placeholder="Senha" type="password" name="password" />

                                        <div class='remember-me checkbox'>
                                            <label for='user_remember_me'>
                                                <input name="remember_me" type="hidden" value="0"/>
                                                <input type="checkbox" value="1" name="remember_me" id="user_remember_me"/>
                                                <span>Lembrar de mim</span>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="submit" value="Entrar" class="btn btn-save"/>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
</body>

@endsection