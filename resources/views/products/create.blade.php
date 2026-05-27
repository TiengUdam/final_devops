<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Add Product</title>

    <!-- Bootstrap 5 & Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --glass-bg: rgba(255, 255, 255, 0.95);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
            background-image:
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(168, 85, 247, 0.15) 0px, transparent 50%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .card {
            border: none;
            border-radius: 24px;
            background: var(--glass-bg);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card-header {
            background: var(--primary-gradient);
            padding: 30px;
            text-align: center;
            border: none;
        }

        .card-header h2 {
            color: white;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .form-label {
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            border-color: #6366f1;
            background-color: white;
        }

        .image-upload-wrapper {
            position: relative;
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            background: #fff;
        }

        .image-upload-wrapper:hover {
            border-color: #6366f1;
            background: #f5f3ff;
        }

        .preview-img {
            width: 100%;
            max-height: 200px;
            object-fit: contain;
            border-radius: 12px;
            display: none;
        }

        .upload-icon {
            font-size: 2rem;
            color: #94a3b8;
            margin-bottom: 10px;
        }

        .btn-save {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            color: white;
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.4);
            filter: brightness(1.1);
            color: white;
        }

        /* Footer Styling */
        footer {
            background: white;
            padding: 30px 0;
            border-top: 1px solid #e2e8f0;
            margin-top: auto;
        }

        .footer-link {
            color: #64748b;
            text-decoration: none;
            transition: color 0.2s;
            margin: 0 15px;
        }

        .footer-link:hover {
            color: #6366f1;
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fas fa-plus-circle me-2"></i>New Product</h2>
                        <p class="text-white-50 mb-0 mt-2">Fill in the details to list a new item</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="/store" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- Product Name -->
                            <div class="mb-4">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="name" class="form-control" placeholder=" Input Name" required>
                            </div>

                            <div class="row">
                                <!-- Price -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Price ($)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 rounded-start-3">$</span>
                                        <input type="number" name="price" class="form-control border-start-0" placeholder="0.00" required>
                                    </div>
                                </div>
                                <!-- Category -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="form-select">
                                        <option value="Matcha">Matcha</option>
                                        <option value="Coffee">Coffee</option>
                                        <option value="Tea">Tea</option>
                                        <option value="Frappe">Hot</option>
                                        <option value="Hot">Frappe</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-4">
                                <label class="form-label">Product Image</label>
                                <div class="image-upload-wrapper" id="dropzone">
                                    <input type="file" name="image" class="form-control position-absolute opacity-0 top-0 start-0 w-100 h-100" style="cursor:pointer" onchange="previewImage(event)">
                                    <div id="upload-placeholder">
                                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                        <p class="mb-0 text-secondary">Click or drag image here</p>
                                    </div>
                                    <img id="preview" class="preview-img">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-save w-100">
                                <i class="fas fa-save me-2"></i>Publish Product
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modern Footer -->
<footer>
    <div class="container text-center">
        <div class="mb-3">
            <a href="#" class="footer-link">Inventory</a>
            <a href="#" class="footer-link">Sales</a>
            <a href="#" class="footer-link">Settings</a>
            <a href="#" class="footer-link">Support</a>
        </div>
        <p class="text-secondary small mb-0">&copy; 2026 Phone Shop Manager. All rights reserved.</p>
        <div class="mt-2">
            <a href="#" class="text-secondary me-3"><i class="fab fa-facebook"></i></a>
            <a href="#" class="text-secondary me-3"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-secondary"><i class="fab fa-instagram"></i></a>
        </div>
    </div>
</footer>

<script>
function previewImage(event) {
    const reader = new FileReader();
    const placeholder = document.getElementById('upload-placeholder');
    const output = document.getElementById('preview');

    reader.onload = function(){
        output.src = reader.result;
        output.style.display = 'block';
        placeholder.style.display = 'none';
    };

    if(event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script>

</body>
</html>
