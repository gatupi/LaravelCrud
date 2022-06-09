<!--
    RECEBE:
        $list,
        $meta ('columns', 'title', 'routes', 'lang')
-->
<table class="list customer-list">
    <thead>
        <tr>
            @foreach($meta['columns'][$meta['lang']] as $col)
            <th>{{$col}}</th>
            @endforeach
            <th colspan="3">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list as $item)
        <tr>
            @foreach($meta['columns']['keys'] as $key)
            <td>
                @if($key != 'active')
                    {{ $item[$key] }}
                @elseif($item[$key])
                    <img src="{{asset('img/true-trimmy.png')}}" alt="true icon" class="icon">
                @else
                    <img src="{{asset('img/false-trimmy.png')}}" alt="true icon" class="icon">
                @endif
            </td>
            @endforeach
            <td class="details icon">
                <a href="{{route($meta['routes']['show'], $item['id'])}}">
                    <img title="Detalhes" src="{{asset('img/details-icon.jpg')}}" alt="details icon">
                </a>
            </td>
            <td class="edit icon">
                <a href="{{route($meta['routes']['edit'], $item['id'])}}">
                    <img title="Editar" src="{{asset('img/edit-icon-2.png')}}" alt="edit icon">
                </a>
            </td>
            <td class="delete icon">
                <form action="{{route($meta['routes']['destroy'], $item['id'])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input title="Excluir" class="_icon" type="image" src="{{asset('img/delete-icon.png')}}" alt="delete icon">
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@component('components.pagination_footer', compact('formId', 'maxPages', 'page'))
@endcomponent