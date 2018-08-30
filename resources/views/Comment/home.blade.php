@extends('Layout')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>

@endpush

@section('content')
    <div class="row pt-5">
        <div class=" col-6 pr-5">
            @include('Comment._form')
        </div>
        <div class=" col-6" id="messages">
            @each('Comment._item', $comments, 'comment','Comment._empty_item')
        </div>
    </div>
@endsection

@push('footer')
    <script>
        $('[data-fancybox="gallery"]').fancybox({
            loop     : true
        });
    </script>
@endpush
