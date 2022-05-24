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
    <video
      style="max-width: 320px;"
      class="img-responsive"
      controls>
      <source
        id="video-show-{{ $field }}"
        src="{{ $img ? $img : '' }}" />
      您的浏览器不支持 HTML5 video 标签。
    </video>
    <br />
    <a class="btn btn-app" id="up{{ $field }}">
      <i class="fa fa-video-camera"></i> 选择视频
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
            $('#video-show-{{ $field }}').attr({src: url})
            uploader{{$field}}.hideDialog()
          }
				})
			})
		})

  })
  </script>
@endpush
