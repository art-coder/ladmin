{!! operation_hints($moduleName, 'permissionForm') !!}

@section('title', $title)

@component('admin::components.form-group', ['title' => '权限名称', 'field' => 'name', 'model' => $permission, 'errors' => $errors ])
@endcomponent

@component('admin::components.form-group', ['title' => '权限描述', 'field' => 'info', 'model' => $permission, 'errors' => $errors ])
@endcomponent
