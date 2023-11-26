<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-SHOP API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark mb-3">
    <div class="container">
        <a class="navbar-brand" href="#">E-SHOP API</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3"><ul class="list-group" id="categories-list"></ul></div>
        <div class="col-lg-9 col-md-9">
            <div class="row" id="products-container"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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

</body>
</html>
