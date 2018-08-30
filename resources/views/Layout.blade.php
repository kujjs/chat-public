<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>Chat public</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        @stack('css')
    </head>
    <body>
        <div class="container">
            @yield('content')
        </div>

        @stack('footer')
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="http://localhost:3000/socket.io/socket.io.js"></script>
        <script>
            var socket = io.connect('http://localhost:3000');

            socket.on('message', function(data) {
                $('#noMessage').remove();
                html = '<div class="border-bottom">';
                html += '<p>'+ data.name +' <span class="text-secondary"> — '+ data.created_at +'</span></p>';
                html += '</div>';
                html += '<p class="text-justify">'+ data.body +'</p>';
                html += '<div class="row text-center text-lg-left">';
                html += renderGalery(data.media);
                html += '</div>';
                html += '';
                $('#messages').prepend(html)

            });
            function renderGalery(medias) {

                html = '';
                medias.forEach(function(el, index) {
                    html += '<div class="col-lg-3 col-md-4 col-xs-6">';
                    html += '<a data-fancybox="gallery" href="'+ el.url+ '" class="d-block mb-4 h-100">';
                    html += renderItemGalery(el);
                    html += '</a>';
                    html += '</div>';

                })
                return html;
            }
            function renderItemGalery(element) {
                if (element.is_image){
                    return '<img src="'+ element.url+ '" class="img-fluid img-thumbnail"/>'
                }
                return '<video src="'+ element.url+ '" class="img-fluid img-thumbnail"></video>'
            }
        </script>
    </body>
</html>
