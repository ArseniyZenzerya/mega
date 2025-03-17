@extends('layouts.app')

@section('title', 'Корзина')

@section('content')
    @component('components.header') @endcomponent

    <div class="container mt-4" x-data="cart()">
        <h1>Корзина</h1>
        <template x-if="cartItems.length === 0">
            <p>Ваша корзина пуста.</p>
        </template>
        <template x-if="cartItems.length > 0">
            <div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Цена</th>
                        <th>Количество</th>
                        <th>Итого</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <template x-for="cartItem in cartItems" :key="cartItem.id">
                        <tr>
                            <td x-text="cartItem.product.name"></td>
                            <td x-text="cartItem.product.price + ' грн.'"></td>
                            <td>
                                <input type="number" x-model="cartItem.quantity" min="1" class="form-control me-2" style="width: 70px;" @change="updateCart(cartItem)">
                            </td>
                            <td x-text="(cartItem.product.price * cartItem.quantity) + ' грн.'"></td>
                            <td>
                                <button @click="removeFromCart(cartItem)" class="btn btn-danger">Удалить</button>
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
                <a href="{{ route('order.checkout') }}" class="btn btn-success mt-4">Оформить заказ</a>
            </div>
        </template>
    </div>

    <script>
        function cart() {
            return {
                cartItems: @json($cartItems),
                updateCart(cartItem) {
                    if (cartItem.quantity > cartItem.product.stock) {
                        alert(`Максимально доступное количество для "${cartItem.product.name}" — ${cartItem.product.stock} шт.`);
                        cartItem.quantity = cartItem.product.stock;
                        return;
                    }

                    fetch(`{{ route('cart.update', '') }}/${cartItem.product.id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ quantity: cartItem.quantity })
                    }).then(response => response.json())
                        .then(data => console.log('Cart updated', data))
                        .catch(error => console.error('Ошибка:', error));
                },
                removeFromCart(cartItem) {
                    fetch(`{{ route('cart.remove', '') }}/${cartItem.product.id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        }
                    }).then(response => {
                        if (response.ok) {
                            this.cartItems = this.cartItems.filter(item => item.id !== cartItem.id);
                        } else {
                            console.error('Ошибка при удалении товара');
                        }
                    }).catch(error => console.error('Ошибка:', error));
                }
            }
        }
    </script>
@endsection
