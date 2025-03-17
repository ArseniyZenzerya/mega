@extends('layouts.app')

@section('title', 'Заказ оформлен')

@section('content')
    <div class="container mt-4 text-center">
        <h1>Спасибо за ваш заказ!</h1>
        <p>Ваш заказ успешно оформлен.</p>
        <a href="{{ route('catalog.index') }}" class="btn btn-primary">Вернуться на главную</a>
    </div>
@endsection
