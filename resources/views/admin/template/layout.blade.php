<!DOCTYPE html>
<html lang='en'>
    <head prefix='og: http://ogp.me/ns#'>
        <meta charset='utf-8'>
        <meta content='IE=edge' http-equiv='X-UA-Compatible'>
        <meta content='object' property='og:type'>
        <meta content='GitLab' property='og:site_name'>
        <meta content='Sign in' property='og:title'>
        <meta content='GitLab Community Edition' property='og:description'>
        <meta content='https://gitlab.softbox.com.br/assets/gitlab_logo-f94735ed1486ec1e35ce78e4c1747b4d.png' property='og:image'>
        <meta content='https://gitlab.softbox.com.br/users/sign_in' property='og:url'>
        <meta content='summary' property='twitter:card'>
        <meta content='Sign in' property='twitter:title'>
        <meta content='GitLab Community Edition' property='twitter:description'>
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.16/vue.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.7.0/vue-resource.min.js" type="text/javascript"></script>

        <title>Backoffice - La Mesa Bonita</title>
        <meta content='GitLab Community Edition' name='description'>

        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/images/favicon.ico" type="image/x-icon">

        <link rel="stylesheet" media="all" href="/admin/css/app.css" />
        {{--<script src="/admin/js/app.js"></script>--}}
        <meta name="csrf-param" content="authenticity_token" />
        <meta name="csrf-token" content="aajIzDKAsv9tRf3JYeo7mxZPkAjp8XfXEKoCe0C5NqJ1TWAeJ2X9RchIsymM+RolrpL2NMvgUl+BdDXxekepKQ==" />
        <script>
            //<![CDATA[
            window.gon={};gon.api_version="v3";gon.default_avatar_url="https://gitlab.softbox.com.br/assets/no_avatar-0801eb7ed213327da2a534095a75b248.png";gon.default_issues_tracker="gitlab";gon.max_file_size=10;gon.relative_url_root="";gon.user_color_scheme="white";
            //]]>
        </script>
        <meta content='origin-when-cross-origin' name='referrer'>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'>
        <meta content='#474D57' name='theme-color'>
        <meta content='/assets/msapplication-tile-2efcb14bec26fd879dd1914db581f8f9.png' name='msapplication-TileImage'>
        <meta content='#30353E' name='msapplication-TileColor'>

        <script src="/admin/vendor/js/jquery-1.12.1.min.js" type="text/javascript"></script>
        <script src="/admin/vendor/js/sweetalert2.min.js" type="text/javascript"></script>
        <link rel="stylesheet" href="/admin/vendor/css/sweetalert2.css" rel="stylesheet">

        <script src="/admin/js/custom.js" type="text/javascript"></script>

        <style>
            [data-user-is] {
                display: none !important;
            }

            [data-user-is=""] {
                display: block !important;
            }

            [data-user-is=""][data-display="inline"] {
                display: inline !important;
            }

            [data-user-is-not] {
                display: block !important;
            }

            [data-user-is-not][data-display="inline"] {
                display: inline !important;
            }

            [data-user-is-not=""] {
                display: none !important;
            }

            [v-cloak] {
                display: none;
            }
        </style>

    </head>

        @yield('content')

        <script src="/admin/js/menu.vue.js" type="text/javascript"></script>

        @if(session()->has('sweet_alert'))
        <script type="text/javascript">
            swal("{!! session('sweet_alert.title') !!}", "{!! session('sweet_alert.message') !!}", "{{ session('sweet_alert.type') }}");
        </script>
        @endif

    </body>

</html>