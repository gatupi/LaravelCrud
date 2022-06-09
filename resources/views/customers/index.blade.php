@extends('layouts.main')
@section('content')
<h2 class="list-title">{{$title}}</h2>
<a href="{{route('customer.create')}}">Novo</a> <!-- redireciona pro formulario -->
@if(count($customers) > 0)
    {{-- <ul>
        @foreach ($customers as $c)
            <li>{{$c['id']}}, {{ $c['nome'] }} |
                <a href="{{route('customer.show', $c['id'])}}" style="font-weight: bold;">Info</a> |
                <a href="{{route('customer.edit', $c['id'])}}">Edit</a>
                <form action="{{route('customer.destroy', $c['id'])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="apagar">
                </form>
            </li>
        @endforeach
    </ul> --}}
    <table class="list customer-list">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Nascimento</th>
                <th>Idade</th>
                <th>Sexo</th>
                <th colspan="3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $c)
            <tr>
                <td class="id-row">{{$c->getId()}}</td>
                <td class="name-val">{{$c->getFullName()}}</td>
                <td class="dob-row">{{$c->getDateOfBirth()}}</td>
                <td class="age-row">{{$c->getAge()}}</td>
                <td class="sex-row">{{$c->getSex()}}</td>
                <td class="details icon">
                    <a href="{{route('customer.show', $c->getId())}}">
                        <img title="Detalhes" src="{{asset('img/details-icon.jpg')}}" alt="details icon">
                    </a>
                </td>
                <td class="edit icon">
                    <a href="{{route('customer.edit', $c->getId())}}">
                        <img title="Editar" src="{{asset('img/edit-icon-2.png')}}" alt="edit icon">
                    </a>
                </td>
                <td class="delete icon">
                    <form action="{{route('customer.destroy', $c->getId())}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input title="Excluir" class="_icon" type="image" src="{{asset('img/delete-icon.png')}}" alt="delete icon">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@else
<h2>Nenhum cliente encontrado</h2>
@endif
@endsection
