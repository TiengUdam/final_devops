<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Phone Shop</title>

    <!-- Bootstrap 5 & Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #4f46e5;
            --bg-light: #f0f2f5;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-attachment: fixed;
        }

        /* --- Header / Navbar --- */
        .navbar {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }

        .badge-count {
            position: absolute;
            top: -8px;
            right: -12px;
            background: #ef4444;
            color: white;
            font-size: 0.7rem;
            min-width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* --- Filter Section --- */
        .filter-section {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            margin-bottom: 40px;
        }

        /* --- Product Card --- */
        .card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .img-container {
            height: 220px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card img {
            width: 70%;
            transition: transform 0.5s ease;
            object-fit: contain;
        }

        .btn-cart {
            background: var(--primary-color);
            border: none;
            border-radius: 12px;
            padding: 10px 15px;
            color: white;
        }

        /* --- Modal Styling --- */
        .modal-content {
            border-radius: 25px;
            border: none;
            overflow: hidden;
        }

          footer {
            background: #1e293b;
            color: #f8fafc;
            padding: 50px 0 20px;
            margin-top: auto;
        }
        .footer-title {
            font-weight: 700;
            margin-bottom: 20px;
        }

        .footer-link {
            color: #94a3b8;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            transition: 0.2s;
        }

        .footer-link:hover {
            color: white;
            padding-left: 5px;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/"><i class=""></i>Nang Cafe</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
    <!-- Home -->
    <li class="nav-item">
        <a class="nav-link {{ request()->is('/') ? 'active fw-bold' : '' }}"
           href="{{ route('home') }}">Home</a>
    </li>

    <!-- Shop -->
    <li class="nav-item">
        <a class="nav-link {{ request()->is('shop') ? 'active fw-bold' : '' }}"
           href="{{ route('shop') }}">Shop</a>
    </li>

    <!-- Categories -->
    <li class="nav-item">
        <a class="nav-link {{ request()->is('categories') ? 'active fw-bold' : '' }}"
           href="{{ route('categories') }}">Categories</a>
    </li>
</ul>
             <div class="d-flex align-items-center">
                <a href="/create" class="btn btn-outline-primary rounded-pill px-4 me-3">
                    <i class="fas fa-plus me-1"></i> Add
                </a>
                <a href="/cart" class="position-relative text-dark fs-5">
                    <i class="fas fa-shopping-basket"></i>
                    <span class="badge-count">{{ session('cart') ? count(session('cart')) : 0 }}</span>
                </a>
            </div>
        </div>
    </div>
</nav>


<div class="container py-5">

    <!-- SEARCH & FILTER SECTION (បង្វិលមកវិញហើយ) -->
    <div class="filter-section">
        <form class="row g-3" method="GET" action="/">
            <div class="col-lg-4 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search for drink" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <select name="category" class="form-select border-0 bg-light">
                    <option value="">All Brands</option>
                    <option value="iPhone" {{ request('category') == 'iPhone' ? 'selected' : '' }}>Matcha</option>
                    <option value="Samsung" {{ request('category') == 'Samsung' ? 'selected' : '' }}>Coffee</option>
                    <option value="Oppo" {{ request('category') == 'Oppo' ? 'selected' : '' }}>Frappe</option>
                    <option value="Vivo" {{ request('category') == 'Vivo' ? 'selected' : '' }}>Hot</option>
                    <option value="Nokia" {{ request('category') == 'Nokia' ? 'selected' : '' }}>Tea</option>
                </select>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="input-group">
                    <input type="number" name="min" class="form-control bg-light border-0" placeholder="Min $" value="{{ request('min') }}">
                    <span class="input-group-text bg-light border-0">-</span>
                    <input type="number" name="max" class="form-control bg-light border-0" placeholder="Max $" value="{{ request('max') }}">
                </div>
            </div>
            <div class="col-lg-2">
                <button type="submit" class="btn btn-dark w-100 rounded-3">Filter Results</button>
            </div>
        </form>
    </div>

    <!-- PRODUCT GRID -->
    <h4 class="mb-4 fw-bold">🔥 Featured Products</h4>
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <!-- CLICK CARD TO SHOW MODAL -->
            <div class="card shadow-sm" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
                <div class="img-container">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}">
                </div>
                <div class="card-body">
                    <p class="text-uppercase text-muted small mb-1">{{ $product->category }}</p>
                    <h5 class="fw-bold text-truncate">{{ $product->name }}</h5>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="product-price fw-bold text-primary fs-5">${{ number_format($product->price, 2) }}</span>

                        <!-- STOP PROPAGATION ON CART BUTTON -->
                        <form action="/add-to-cart/{{ $product->id }}" method="POST" onclick="event.stopPropagation();">
                            @csrf
                            <button type="submit" class="btn btn-cart">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL DETAIL -->
        <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="row g-0">
                            <div class="col-md-6 bg-light d-flex align-items-center justify-content-center p-4">
                                <img src="{{ $product->image }}" class="img-fluid" style="max-height: 400px; object-fit: contain;">
                            </div>
                            <div class="col-md-6 p-4 p-lg-5">
                                <div class="d-flex justify-content-between">
                                    <span class="badge bg-primary-subtle text-primary mb-2">{{ $product->category }}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <h2 class="fw-bold">{{ $product->name }}</h2>
                                <h3 class="text-primary fw-bold my-4">${{ number_format($product->price, 2) }}</h3>
                                <h6 class="fw-bold">Description:</h6>
                                <p class="text-muted">{{ $product->description ?? 'Premium smartphone with high performance and elegant design.' }}</p>
                                <div class="d-grid mt-5">
                                    <form action="/add-to-cart/{{ $product->id }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary py-3 fw-bold rounded-3">
                                            <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- FOOTER -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="footer-title">Nang Cafe</h5>
                <p class="text-secondary">Welcome to coffee shop</p>
                <div class="mt-3">
                    <a href="#" class="text-white me-3 fs-5"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-white me-3 fs-5"><i class="fab fa-telegram"></i></a>
                    <a href="#" class="text-white fs-5"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-md-2 mb-4">
                <h6 class="footer-title">Quick Links</h6>
                <a href="#" class="footer-link">Latest Models</a>
                <a href="#" class="footer-link">Special Offers</a>
                <a href="#" class="footer-link">Pre-order</a>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="footer-title">Customer Service</h6>
                <a href="#" class="footer-link">Shipping Policy</a>
                <a href="#" class="footer-link">Warranty</a>
                <a href="#" class="footer-link">Return & Exchange</a>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="footer-title">Contact Us</h6>
                <p class="text-secondary small"><i class="fas fa-map-marker-alt me-2"></i> Phnom Penh, Cambodia</p>
                <p class="text-secondary small"><i class="fas fa-phone me-2"></i> +855 66 424215</p>
                <p class="text-secondary small"><i class="fas fa-envelope me-2"></i> phonedom@smart.com</p>
            </div>
        </div>
        <hr class="border-secondary mt-4">
        <p class="text-center text-secondary small mb-0">&copy; Nang Cafe. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>/script>
</body>
</html>
