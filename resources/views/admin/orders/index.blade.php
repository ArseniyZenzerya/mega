@extends('layouts.app')

@section('title', 'Заказы')

@section('content')
    <h1>Заказы</h1>
    <div x-data="orderList()">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Пользователь</th>
                <th>Статус</th>
                <th>Сумма</th>
                <th>Метод доставки</th>
                <th>Метод оплаты</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <template x-for="order in orders" :key="order.id">
                <tr>
                    <td x-text="order.user.name"></td>
                    <td>
                        <select x-model="order.status" class="form-select" @change="updateStatus(order)">
                            <option value="new">Новый</option>
                            <option value="processing">В обработке</option>
                            <option value="completed">Завершен</option>
                        </select>
                    </td>
                    <td x-text="order.total_amount + ' грн.'"></td>
                    <td x-text="order.delivery_method"></td>
                    <td x-text="order.payment_method"></td>
                    <td>
                        <a :href="'{{ url('admin/orders') }}/' + order.id" class="btn btn-info btn-sm">Просмотр</a>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>

    <script>
        function orderList() {
            return {
                orders: @json($orders),
                updateStatus(order) {
                    fetch(`{{ url('admin/orders') }}/${order.id}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ status: order.status })
                    }).then(response => {
                        if (!response.ok) {
                            console.error('Ошибка обновления статуса');
                        }
                    }).catch(error => console.error('Ошибка:', error));
                }
            }
        }
    </script>
@endsection
