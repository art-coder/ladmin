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
    <img
      class="img-responsive"
      style="max-width: 300px;"
      id="image-show-{{ $field }}"
      src="{{ $img ? $img : '/assets/images/no-image.jpg' }}"
      alt="{{ $title }}"
    /><br />
    <a class="btn btn-app" id="up{{ $field }}">
      <i class="fa fa-image"></i> 选择图片
    </a>
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
            K('#{{ $field }}').val(url)
            $('#image-show-{{ $field }}').attr({src: url})
            uploader{{$field}}.hideDialog()
          }
				})
			})
		})

  })
  </script>
@endpush
