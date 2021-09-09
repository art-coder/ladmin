<div class="form-group">
  <label for="is_recommend" class="col-sm-2 control-label">{{$title}}</label>
  <div class="col-sm-10">
    <select id="is_recommend" class="form-control" name="is_recommend">
      <option value="0" {{ old('is_recommend', $model->is_recommend) === 0 ? 'selected' : '' }}>不推荐</option>
      <option value="1" {{ old('is_recommend', $model->is_recommend) === 1 ? 'selected' : '' }}>推荐</option>
    </select>
  </div>
</div>
