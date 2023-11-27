@extends('layout.main')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-3">
            <ul class="list-group" id="categories-list"></ul>
        </div>
        <div class="col-lg-9 col-md-9">
            <div class="row" id="products-container"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            var categoriesList = $('#categories-list');
            var productsContainer = $('#products-container');

            // Fetch categories
            $.get('/api/categories', function (response) {
                console.log(response.categories); // Log the entire response to the console

                response.categories.forEach(function (category) {
                    var listItem = $('<li class="list-group-item"></li>');
                    var link = $('<a href="#">' + category.name + '</a>');
                    listItem.append(link);
                    categoriesList.append(listItem);

                    // Add click event to load products for the selected category
                    link.click(function () {
                        loadProducts(category);
                    });
                });

                // Load products for the first category
                if (response.categories.length > 0) {
                    loadProducts(response.categories[0]);
                }
            });

            // Function to fetch and display products for a category
            function loadProducts(category) {
                $.get('/api/categories/' + category.id + '/products', function (response) {
                    productsContainer.empty(); // Clear existing products

                    console.log(response.products);

                    response.products.forEach(function (product) {
                        var productCard = createProductCard(product);
                        productsContainer.append(productCard);
                    });
                });
            }

            // Function to create a product card
            function createProductCard(product) {
                var productCard = $('<div class="col-lg-4 col-md-4"></div>');
                productCard.append(`
        <div class="card mb-3">
            <img src="https://place-hold.it/700x400" class="card-img-top img-fluid" alt="...">
            <div class="card-body">
                <h4 class="card-title">${product.name}</h4>
                <h6>$${product.price}</h6>
                <p class="card-text">${product.description}</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    `);
                return productCard;
            }
        });
    </script>
@endsection
