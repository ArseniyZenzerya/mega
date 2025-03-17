@extends('layouts.app')

@section('title', 'Каталог товаров')

@section('content')
    @component('components.header') @endcomponent

    <div class="container mt-4" x-data="catalog()">
        <h1>Каталог товаров</h1>

        <div class="row">
            <div class="col-md-9">
                <form class="mb-4">
                    <div class="input-group">
                        <input type="text" x-model="search" class="form-control" placeholder="Поиск по названию или артикулу" @input="resetPagination">
                    </div>
                </form>

                <div class="row">
                    <template x-for="product in paginatedProducts" :key="product.id">
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img :src="'storage/' + product.image" class="card-img-top" :alt="product.name" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title" x-text="product.name"></h5>
                                    <p class="card-text" x-text="product.price + ' грн.'"></p>
                                    <a :href="'/product/' + product.id" class="btn btn-primary">Подробнее</a>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <button class="btn btn-outline-primary mx-1" @click="prevPage" :disabled="currentPage === 1">Назад</button>
                    <span x-text="currentPage + ' / ' + totalPages"></span>
                    <button class="btn btn-outline-primary mx-1" @click="nextPage" :disabled="currentPage === totalPages">Вперед</button>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Фильтры</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="min_price">Мин. цена</label>
                            <input type="number" id="min_price" x-model.number="minPrice" class="form-control" @input="resetPagination">
                        </div>
                        <div class="form-group">
                            <label for="max_price">Макс. цена</label>
                            <input type="number" id="max_price" x-model.number="maxPrice" class="form-control" @input="maxPrice = maxPrice || Infinity; resetPagination()">
                        </div>
                        <div class="form-group">
                            <label for="sort_by">Сортировка</label>
                            <select id="sort_by" x-model="sortBy" class="form-control" @change="resetPagination">
                                <option value="">По умолчанию</option>
                                <option value="name">По алфавиту</option>
                                <option value="price">По цене</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function catalog() {
            return {
                search: '{{ request('search') }}',
                minPrice: parseFloat('{{ request('min_price') }}') || 0,
                maxPrice: parseFloat('{{ request('max_price') }}') || Infinity,
                sortBy: '{{ request('sort_by') }}',
                products: @json($products->toArray()['data'] ?? $products),
                currentPage: 1,
                itemsPerPage: 2,
                get filteredProducts() {
                    return this.products
                        .filter(product => {
                            return (!this.search || product.name.toLowerCase().includes(this.search.toLowerCase())) &&
                                (this.minPrice === 0 || product.price >= this.minPrice) &&
                                (this.maxPrice === Infinity || product.price <= this.maxPrice);
                        })
                        .sort((a, b) => {
                            if (this.sortBy === 'name') return a.name.localeCompare(b.name);
                            if (this.sortBy === 'price') return a.price - b.price;
                            return 0;
                        });
                },
                get totalPages() {
                    return Math.ceil(this.filteredProducts.length / this.itemsPerPage);
                },
                get paginatedProducts() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    return this.filteredProducts.slice(start, start + this.itemsPerPage);
                },
                nextPage() {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++;
                    }
                },
                prevPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                    }
                },
                resetPagination() {
                    this.currentPage = 1;
                }
            };
        }
    </script>
@endsection
