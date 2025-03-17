@extends('layouts.app')

@section('title', 'Товары')

@section('content')
    <h1>Товары</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-success mb-3">Добавить товар</a>

    <div x-data="productList()">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Название</th>
                <th>Цена</th>
                <th>Описание</th>
                <th>Фото</th>
                <th>Количество</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <template x-for="product in products" :key="product.id">
                <tr>
                    <td x-text="product.name"></td>
                    <td x-text="product.price"></td>
                    <td x-text="product.description"></td>
                    <td>
                        <img :src="'{{ asset('storage/') }}' + '/' + product.image" :alt="product.name" width="50">
                    </td>
                    <td x-text="product.stock"></td>
                    <td>
                        <a :href="'{{ url('admin/products') }}/' + product.id + '/edit'" class="btn btn-primary btn-sm">Редактировать</a>
                        <button @click="deleteProduct(product.id)" class="btn btn-danger btn-sm">Удалить</button>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>

    <script>
        function productList() {
            return {
                products: @json($products),
                deleteProduct(productId) {
                    if (confirm('Вы уверены, что хотите удалить этот товар?')) {
                        let formData = new FormData();
                        formData.append('_method', 'DELETE');
                        formData.append('_token', document.querySelector('meta[name=csrf-token]').content);

                        fetch(`{{ url('admin/products') }}/${productId}`, {
                            method: 'POST',
                            body: formData
                        }).then(response => {
                            if (response.ok) {
                                let index = this.products.findIndex(product => product.id === productId);
                                if (index !== -1) this.products.splice(index, 1);
                            } else {
                                console.error('Ошибка при удалении товара');
                            }
                        }).catch(error => console.error('Ошибка:', error));
                    }
                }
            }
        }
    </script>
@endsection
