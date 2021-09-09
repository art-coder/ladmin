<div class="form-group">
  <label for="status" class="col-sm-2 control-label">{{$title}}</label>
  <div class="col-sm-10">
    <select id="status" class="form-control" name="status">
      @foreach ($model->getStatus() as $item)
        <option value="{{ $item->value }}" {{ old('status', $item->value) === $model->getState()->value ? 'selected' : '' }}>{{ $item->label }}</option>
      @endforeach
    </select>
  </div>
</div>
