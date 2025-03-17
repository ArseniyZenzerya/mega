
@extends('layouts.app')

@section('title', 'Оформление заказа')

@section('content')
    <div class="container mt-4">
        <h1>Оформление заказа</h1>
        <form action="{{ route('order.place') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">ФИО</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Телефон</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="delivery_method" class="form-label">Способ доставки</label>
                <select class="form-control" id="delivery_method" name="delivery_method" required>
                    <option value="pickup">Самовывоз</option>
                    <option value="post">Отправка почтой</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="payment_method" class="form-label">Способ оплаты</label>
                <select class="form-control" id="payment_method" name="payment_method" required>
                    <option value="cash">Наложенный платеж</option>
                    <option value="online">Онлайн оплата</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Оформить заказ</button>
        </form>
    </div>
@endsection
