@extends('Layout')

@section('content')
    <div class="row pt-5">
        <div class=" col-6 pr-5">
            <form-message url-upload="{{ route('home.comment.upload') }}"></form-message>
        </div>
        <div class=" col-6" id="messages">
            <list-message></list-message>
        </div>
    </div>
@endsection

@push('footer')
    <script>
        $('[data-fancybox="gallery"]').fancybox({
            loop: true
        });
    </script>
@endpush
