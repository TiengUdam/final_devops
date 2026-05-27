<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - PHONE HUB</title>

    <!-- Bootstrap 5 & Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #4f46e5;
            --bg-light: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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

        .nav-link {
            font-weight: 600;
            color: #475569 !important;
            margin: 0 10px;
        }

        .cart-badge {
            position: relative;
            text-decoration: none;
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
            padding: 2px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* --- Cart Modern Styles --- */
        .cart-card {
            border: none;
            border-radius: 24px;
            background: white;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            padding: 25px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .product-img-wrapper {
            background: #f1f5f9;
            padding: 10px;
            border-radius: 18px;
            width: 90px;
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .qty-control {
            display: flex;
            align-items: center;
            background: #f1f5f9;
            border-radius: 12px;
            padding: 5px;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            border: none;
            background: white;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: 0.2s;
        }

        .qty-btn:hover { background: var(--primary-color); color: white; }

        .summary-box {
            border: none;
            border-radius: 24px;
            padding: 30px;
            background: white;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .btn-checkout {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 16px;
            font-weight: 700;
            width: 100%;
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
            transition: 0.3s;
        }

        .btn-checkout:hover { transform: translateY(-2px); color: white; background: var(--secondary-color); }

        /* --- Payment Modal Styles --- */
        .modal-content {
            border-radius: 28px;
            border: none;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2);
        }

        .qr-container {
            background: #f8fafc;
            padding: 25px;
            border-radius: 24px;
            display: inline-block;
            border: 2px dashed #e2e8f0;
        }

        /* --- Footer --- */
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

<!-- HEADER / NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/"><i class=""></i>Nang Cafe</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Shop</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Categories</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <a href="/cart" class="cart-badge text-dark fs-5">
                    <i class="fas fa-shopping-basket"></i>
                    <span class="badge-count">{{ session('cart') ? count(session('cart')) : 0 }}</span>
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- MAIN CONTENT -->
<div class="container py-5">
    <h2 class="fw-bold mb-4">🛒 Your Shopping Cart</h2>

    <div class="row g-4">
        <!-- LEFT: CART ITEMS -->
        <div class="col-lg-8">
            <div class="cart-card">
                @php $total = 0; @endphp
                @forelse(session('cart', []) as $id => $item)
                    @php
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    @endphp
                    <div class="cart-item">
                        <div class="product-img-wrapper">
                            <img src="{{ $item['image'] }}" class="product-img" alt="Product Image">
                        </div>
                        <div class="flex-grow-1 ms-4">
                            <h6 class="fw-bold mb-1">{{ $item['name'] }}</h6>
                            <p class="text-muted small mb-0">${{ number_format($item['price'], 2) }}</p>
                        </div>
                        <div class="qty-control mx-3">
                            <a href="/decrease/{{ $id }}" class="qty-btn"><i class="fas fa-minus small"></i></a>
                            <span class="mx-3 fw-bold">{{ $item['quantity'] }}</span>
                            <a href="/increase/{{ $id }}" class="qty-btn"><i class="fas fa-plus small"></i></a>
                        </div>
                        <div class="text-end" style="min-width: 100px;">
                            <span class="fw-bold text-primary fs-5">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="ms-4">
                            <a href="/remove/{{ $id }}" class="text-danger"><i class="fas fa-trash-alt"></i></a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <p class="text-muted">Your cart is empty.</p>
                        <a href="/" class="btn btn-outline-primary rounded-pill px-4">Go Shopping</a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- RIGHT: SUMMARY -->
        <div class="col-lg-4">
            <div class="summary-box">
                <h5 class="fw-bold mb-4">Order Summary</h5>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-bold">${{ number_format($total, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-4">
                    <span class="text-muted">Shipping</span>
                    <span class="text-success fw-bold">Free</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center my-4">
                    <span class="fs-5 text-muted">Total</span>
                    <span class="fs-3 fw-bold">${{ number_format($total, 2) }}</span>
                </div>

                <!-- Triggering the Payment Modal -->
                <button class="btn btn-checkout" data-bs-toggle="modal" data-bs-target="#paymentModal">
                    Checkout Now
                </button>

                <a href="/" class="btn btn-link w-100 text-decoration-none text-muted small mt-2">
                    <i class="fas fa-chevron-left me-1"></i> Back to shopping
                </a>
            </div>
        </div>
    </div>
</div>

<!-- PAYMENT MODAL (QR CODE) -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center px-4 pb-5">
                <div class="mb-4">
                    <i class="fas fa-qrcode text-primary fs-1 mb-3"></i>
                    <h4 class="fw-bold">Scan to Pay</h4>
                    <p class="text-muted small">Use your banking app to scan the QR code and complete the purchase for your drink.</p>
                </div>

                <div class="mb-4">
                    <p class="mb-1 text-muted">Amount Due</p>
                    <h2 class="fw-bold text-primary">${{ number_format($total, 2) }}</h2>
                </div>

                <div class="qr-container">
                    <!-- Dynamic QR generation based on total -->
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=PhoneHub_Payment_{{ $total }}"
                         alt="Payment QR Code"
                         class="img-fluid">
                </div>

                <div class="mt-4 pt-2">
                    <div class="d-flex align-items-center justify-content-center text-muted small">
                        <i class="fas fa-lock me-2"></i>
                        <span>Secure SSL Encrypted Payment</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="footer-title">Nang Cafe</h5>
                <p class="text-secondary">Welocome to cafe</p>
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

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
