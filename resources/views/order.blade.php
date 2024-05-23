@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <span>Все доступные пользователю автомобили (учитывая категории) </span>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Модель авто</th>
                                <th scope="col">Категория авто</th>
                                <th scope="col">Описание категории</th>
                                <th scope="col">Водитель</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $availableCars as $car)
                                <tr>
                                    <td>{{ $car->id }}</td>
                                    <td>{{ $car->model }}</td>
                                    <td>{{ $car->name }}</td>
                                    <td>{{ $car->description }}</td>
                                    <td>{{ $car->first_name }} {{ $car->last_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <span>Планирование заказа</span>
                    <form method="post" action=" {{ route('order') }}">
                        @csrf
                        <div>
                            <label for="start_datetime">Начало заказа</label>
                            <input type="datetime-local" name="start_datetime" required/>

                            <label for="end_datetime">Окончание заказа</label>
                            <input type="datetime-local" name="end_datetime" required/>
                        </div>
                        <div class="d-flex mt-4">
                            <input class="btn btn-success" type="submit" value="Получить список" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
