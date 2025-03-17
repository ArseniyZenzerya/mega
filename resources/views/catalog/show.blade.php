@extends('layouts.app')

@section('title', $product->name)

@section('content')
    @component('components.header') @endcomponent

    <div class="container mt-4">
        <div class="mt-4">
            <a href="{{ route('catalog.index') }}" class="btn btn-secondary">Назад в каталог</a>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
            </div>
            <div class="col-md-6">
                <h1>{{ $product->name }}</h1>
                <h3>{{ $product->price }} грн.</h3>
                <p>{{ $product->description }}</p>

                @if($product->stock > 0)
                    <p>В наличии: {{ $product->stock }} шт.</p>
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Добавить в корзину</button>
                    </form>
                @else
                    <p class="text-danger">Товар временно отсутствует на складе</p>
                @endif
            </div>
        </div>
    </div>
@endsection
