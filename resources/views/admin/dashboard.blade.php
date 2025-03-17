@extends('layouts.app')

@section('title', 'Админ-панель')

@section('content')
    <h1>Добро пожаловать в админ-панель</h1>
    <div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Управление товарами</a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Управление заказами</a>
    </div>
@endsection
