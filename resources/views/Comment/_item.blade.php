
<div class="border-bottom">
    <p>{{ $comment->name }} <span class="text-secondary"> — {{ $comment->created_at }}</span></p>
    <p class="text-justify">
        {{ $comment->body }}

    </p>
    <p>
    <div class="row text-center text-lg-left">
        @foreach($comment->media as $media)
        <div class="col-lg-3 col-md-4 col-xs-6">
            <a data-fancybox="gallery" href="{{ $media->url_real_media }}" class="d-block mb-4 h-100">
            @if($media->isImage())
                <img src="{{ $media->url_real_media }}" class="img-fluid img-thumbnail">
            @else
                <video src="{{ $media->url_real_media }}" class="img-fluid img-thumbnail"></video>
            @endif
            </a>
        </div>
        @endforeach
    </div>
    </p>
</div>

