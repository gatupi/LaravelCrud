<!-- parâmetros:

    $columns
    $list
    $showRoute,
    $editRoute,
    $destroyRoute

-->
<table class="list customer-list">
    <thead>
        <tr>
            @foreach($meta as $m)
            <th>{{$m['pt-br']}}</th>
            @endforeach
            <th colspan="3">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($customers as $c)
        <tr>
            @foreach(array_keys($meta) as $key)
            <td>{{$c[$key]}}</td>
            @endforeach
            <td class="details icon">
                <a href="{{route($route['show'], $c['id'])}}">
                    <img title="Detalhes" src="{{asset('img/details-icon.jpg')}}" alt="details icon">
                </a>
            </td>
            <td class="edit icon">
                <a href="{{route($route['edit'], $c['id'])}}">
                    <img title="Editar" src="{{asset('img/edit-icon-2.png')}}" alt="edit icon">
                </a>
            </td>
            <td class="delete icon">
                <form action="{{route($route['destroy'], $c['id'])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input title="Excluir" class="_icon" type="image" src="{{asset('img/delete-icon.png')}}" alt="delete icon">
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>