@push('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/basic.min.css" />
@endpush

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <h3>{{ __('Please resolve the following errors') }}:</h3>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{{ Form::open(['route'=>'home.comment','method'=>'post','id'=>'FormMessage']) }}
<div class="form-group">
    {{ Form::label('name',__('Username')) }}
    {{ Form::text('name',null,['class'=>'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('body',__('Message')) }}
    {{ Form::textarea('body',null,['class'=>'form-control','rows'=>'6']) }}
</div>
<div class="form-group">
    <div id="dropzoneFile" class="dropzone">
        <div class="dz-message" style="height:120px;">
            {{ __('Drag and drop your photos and videos(max:20mb)') }}
        </div>
    </div>
</div>
<div class="form-group">
    {{ Form::hidden('media',null,['id'=>'media']) }}
    {{ Form::submit(__('Send'),['class'=>'btn btn-block btn-primary']) }}
</div>
{{ Form::close() }}

@push('footer')

    <script src="//cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script>
        var mediaInput = $('#media');
        var mediaArray = [];
        var myDropzone;
        Dropzone.autoDiscover = false;
        myDropzone = new Dropzone('#dropzoneFile',{
            url: "{{ route('home.comment.upload') }}",
            params: {_token: '{{ csrf_token() }}'},
            acceptedFiles: "image/*,video/*",
            paramName: "file", // The name that will be used to transfer the file
            addRemoveLinks: true,
            uploadMultiple: true,
            maxFilesize: 20, // MB
            parallelUploads:1,
            dictRemoveFile:'{{ __('Remove') }}',
            dictInvalidFileType:'{{ __('Remove') }}',
            success: function(file, done) {
                var fileuploded = file.previewElement.querySelector("[data-dz-name]");
                fileuploded.innerHTML = done.name;
                mediaArray.push(done.name);
                mediaInput.val(mediaArray.toString());
            }
        });
        $('#FormMessage').submit(function (event) {
            event.preventDefault();
            console.log($(this).serialize());
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',

                data: $(this).serialize(),
            })
                .done(function() {
                    $('#body').val('');
                    $('#media').val('');
                    mediaArray = [];
                    myDropzone.emit('reset');
                    $(".dz-preview").remove();
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("complete");
                });
        })
        mediaInput = $('#media');

        $(function() {

        mediaArray = mediaInput.val().split(',').filter(function(value){return value!==''});


        $.each(mediaInput.val().split(','), function(key,value){
            if (value == '') {
                return;
            }
            var mockFile = { name: value, size: 100 };
            myDropzone.options.addedfile.call(myDropzone, mockFile);

            myDropzone.options.thumbnail.call(myDropzone,
                mockFile,
                '{{ url('/storage') }}/'+value);

            myDropzone.emit("complete", mockFile);
        });
        myDropzone.on('removedfile', function (file) {

            mediaArray = mediaInput.val().split(',');
            if (file.xhr != null) {
                fileName = JSON.parse(file.xhr.responseText);
                fileName=fileName.file;
            }else{
                fileName = file.name;
            }

            var i = mediaArray.indexOf(fileName);
            if(i != -1) {
                mediaArray.splice(i, 1);
            }
            mediaInput.val(mediaArray);
        });
        });
    </script>
@endpush