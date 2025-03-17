@extends('layouts.app')

@section('content')
    <h1>Детали заказа</h1>
    <p><strong>Пользователь:</strong> {{ $order->user->name }}</p>
    <p><strong>Статус:</strong> {{ $order->status }}</p>
    <p><strong>Сумма:</strong> {{ $order->total_amount }} грн.</p>
    <p><strong>Метод доставки:</strong> {{ $order->delivery_method }}</p>
    <p><strong>Метод оплаты:</strong> {{ $order->payment_method }}</p>

    <h2>Товары</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Название</th>
            <th>Количество</th>
            <th>Цена</th>
            <th>Итого</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->price }} грн.</td>
                <td>{{ $item->quantity * $item->price }} грн.</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Назад к заказам</a>
@endsection
