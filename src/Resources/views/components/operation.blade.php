<a href="{{ route($editRoute, [$id, 'page' => request()->input('page')]) }}">编辑</a> |
<a href="{{ route($deleteRoute, $id) }}" onclick="if(confirm('确认删除此项么，删除后不可恢复')==false)return false;">删除</a>
