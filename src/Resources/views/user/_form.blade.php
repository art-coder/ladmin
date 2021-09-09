@section('css')
<link href="{{config('admin.assets_url.icheck_css')}}" rel="stylesheet">
@stop

@section('title', $title)

@component('admin::components.form-group', ['title' => '昵称', 'field' => 'username', 'model' => $user ])
@endcomponent

@component('admin::components.form-group', ['title' => '邮箱', 'field' => 'email', 'model' => $user ])
@endcomponent

@component('admin::components.form-group-password', ['title' => '密码', 'field' => 'password', 'model' => $user ])
@endcomponent

@component('admin::components.form-group', ['title' => '电话', 'field' => 'phone', 'model' => $user ])
@endcomponent

@if ($user->canUpdateRoles())
  @component('admin::components.form-group-checkbox', ['title' => '角色列表', 'field' => 'rids', 'list' => $role, 'default' => $user->roles->pluck('id')->toArray(), 'model' => $user, 'hasCheck' => true ])
  @endcomponent
@endif

@if($user->canUpdateSuperAdmin())
<div class="form-group">
  <label for="is_super_admin" class="col-sm-2 control-label">是否超级管理员</label>
  <div class="col-sm-10">
    <select id="is_super_admin" class="form-control" name="is_super_admin">
      <option value="0" {{ old('is_super_admin', $user->is_super_admin) === 0 ? 'selected' : '' }}>否</option>
      <option value="1" {{ old('is_super_admin', $user->is_super_admin) === 1 ? 'selected' : '' }}>是</option>
    </select>
  </div>
</div>
@endif

@component('admin::components.form-status', ['title' => '用户状态', 'model' => $user ])
@endcomponent

@section('script')
<script src="{{config('admin.assets_url.icheck_js')}}"></script>
<script>
$('input').iCheck({
　　checkboxClass: 'icheckbox_flat-blue', //每个风格都对应一个，这个不能写错哈。
　　radioClass: 'icheckbox_flat-blue',
});
</script>
@stop
