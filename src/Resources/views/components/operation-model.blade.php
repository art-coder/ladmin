<a href="{{ route('admin.' . $folder . '.edit', [$model->id, 'page' => request()->input('page')]) }}">编辑</a> |
@if (can_delete($model))
<a href="{{ route('admin.' . $folder . '.delete', $model->id) }}" onclick="if(confirm('确认删除此项么，删除后不可恢复')==false)return false;">删除</a>
@else
<span style="text-decoration: line-through; color: #999;">删除</span>
@endif
