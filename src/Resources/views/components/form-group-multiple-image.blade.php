<div class="form-group @error($field) has-error @enderror">
  <label for="{{ $field }}" class="col-sm-2 control-label">{{ $title }}</label>
  <div class="col-sm-10">
    @php
      $img = old($field, $model->$field);
    @endphp
    <input
      type="hidden"
      name="{{ $field }}"
      id="{{ $field }}"
      value="{{ $img }}"
    />
    <ul class="multiple-images-uploader" id="multiple-images-uploader-{{ $field }}">
      @if ($model->$field)
        @php
          $images = explode($separator, $model->$field);
        @endphp
        @foreach ($images as $image)
        <li>
          <img class="img-responsive" style="max-width: 150px;" src="{{ $image }}" />
          <button type="button" class="btn btn-danger btn-flat multiple-images-uploader-delete-btn"><i class="fa fa-close"></i></button>
        </li>
        @endforeach
      @endif
    </ul>
    <div class="image-uploader-bar">
      <a class="btn btn-app" id="up{{ $field }}">
        <i class="fa fa-image"></i> 选择图片
      </a>
    </div>
    @error($field)
      <span class="help-block">{{ $message }}</span>
    @enderror
  </div>
</div>

@push('stack_script')
<script>
KindEditor.ready(function(K) {

  var uploader{{ $field }} = K.editor({
    allowFileManager: false,
    uploadJson: '{{ route('admin.upload') }}',
    extraFileUploadParams: {
      _token: '{{ csrf_token() }}'
    },
    filePostName: 'file'//文件的name值
  })

  K('#up{{ $field }}').click(function() {
    uploader{{$field}}.loadPlugin('image', function() {
      uploader{{$field}}.plugin.imageDialog({
        showRemote: false,
        imageUrl: K('#{{ $field }}').val(),
        clickFn: function(url, title, width, height, border, align) {
          var urls = K('#{{ $field }}').val()
          if (urls) {
            K('#{{ $field }}').val(urls + '{{ $separator }}' + url)
          } else {
            K('#{{ $field }}').val(url)
          }
          $('#multiple-images-uploader-{{ $field }}').append('<li><img class="img-responsive" style="max-width: 150px;" src="' +
            url + '"/><button type="button" class="btn btn-danger btn-flat multiple-images-uploader-delete-btn"><i class="fa fa-close"></i></button></li>');
          uploader{{$field}}.hideDialog()
        }
      })
    })
  })
})

$('#multiple-images-uploader-{{ $field }}').on('click', 'li>button', function(){
  var del = $(this).parent().find('img').attr('src');
  var urls = $('#{{ $field }}').val();
  var urlsArr = urls.split('{{ $separator }}');
  urlsArr.splice(urlsArr.indexOf(del), 1);
  $('#{{ $field }}').val(urlsArr.join('{{ $separator }}'));
  $(this).parent().remove();
});

</script>
@endpush
