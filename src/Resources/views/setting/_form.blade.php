{!! operation_hints($moduleName, 'settingForm') !!}

@section('title', '系统配置')

<div class="form-group {{ $errors->has('item') ? 'has-error' : '' }}">
    <label for="item" class="col-sm-2 control-label">标签(字母)</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="item" id="item" value="{{old('item', $setting->item)}}"  placeholder="标签(字母)">
    </div>
    @if ($errors->has('item'))
        <span class="help-block">{{ $errors->first('item') }}</span>
    @endif
</div>

<div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
    <label for="item" class="col-sm-2 control-label">标签(字母)</label>
    <div class="col-sm-10">
        <select class="form-control" name="type">
            <option value="input">单行文本</option>
            <option value="textarea">多行文本</option>
            <option value="radio">单选</option>
            <option value="checkbox">多选</option>
        </select>
    </div>
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description" class="col-sm-2 control-label">描述</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="description" id="description" value="{{old('description', $setting->description)}}"  placeholder="描述">
    </div>
    @if ($errors->has('description'))
        <span class="help-block">{{ $errors->first('description') }}</span>
    @endif
</div>

<div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
    <label for="content" class="col-sm-2 control-label">内容</label>
    <div class="col-sm-10">
        <textarea name="content" id="content" class="form-control" rows="5">{{$setting->content}}</textarea>
    </div>
    @if ($errors->has('content'))
        <span class="help-block">{{ $errors->first('content') }}</span>
    @endif
</div>

