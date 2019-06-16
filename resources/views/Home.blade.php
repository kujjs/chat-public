<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Chat public</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
<div id="app" class="container">
    <router-view></router-view>
</div>

<script src="{{ asset('js/app.js') }}"></script>

<script>
    $('[data-fancybox="gallery"]').fancybox({
        loop: true
    });
</script>

<script>

</script>
{{--        <script>--}}
{{--            var socket = io.connect('http://localhost:6001');--}}

{{--            socket.on('test', function(data) {--}}
{{--                alert('funca');--}}
{{--            });--}}
{{--            socket.on('message', function(data) {--}}
{{--                $('#noMessage').remove();--}}
{{--                html = '<div class="border-bottom">';--}}
{{--                html += '<p>'+ data.name +' <span class="text-secondary"> — '+ data.created_at +'</span></p>';--}}
{{--                html += '</div>';--}}
{{--                html += '<p class="text-justify">'+ data.body +'</p>';--}}
{{--                html += '<div class="row text-center text-lg-left">';--}}
{{--                html += renderGalery(data.media);--}}
{{--                html += '</div>';--}}
{{--                html += '';--}}
{{--                $('#messages').prepend(html)--}}

{{--            });--}}
{{--            function renderGalery(medias) {--}}

{{--                html = '';--}}
{{--                medias.forEach(function(el, index) {--}}
{{--                    html += '<div class="col-lg-3 col-md-4 col-xs-6">';--}}
{{--                    html += '<a data-fancybox="gallery" href="'+ el.url+ '" class="d-block mb-4 h-100">';--}}
{{--                    html += renderItemGalery(el);--}}
{{--                    html += '</a>';--}}
{{--                    html += '</div>';--}}

{{--                })--}}
{{--                return html;--}}
{{--            }--}}
{{--            function renderItemGalery(element) {--}}
{{--                if (element.is_image){--}}
{{--                    return '<img src="'+ element.url+ '" class="img-fluid img-thumbnail"/>'--}}
{{--                }--}}
{{--                return '<video src="'+ element.url+ '" class="img-fluid img-thumbnail"></video>'--}}
{{--            }--}}
{{--        </script>--}}
</body>
</html>
