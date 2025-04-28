<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
            text-align: center;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        .card-text.price {
            color: #e74c3c;
            font-size: 1.2rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 1rem;
            color: #555;
            margin-bottom: 15px;
        }

        .btn-add-to-cart {
            background-color: #fff;
            color: #000;
            font-weight: bold;
            border: 2px solid #000;
            padding: 10px 20px;
        }
        
        .btn-add-to-cart:hover {
            background-color: #000;
            color: #fff;
            transition: background-color 0.3s, color 0.3s;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }
    </style>
</head>
<body>
    <!-- Sản phẩm -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">Sản phẩm nổi bật</h1>

        <!-- Yonex -->
        <h3 class="mt-4">Yonex</h3>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <div class="col">
                <div class="card h-100">
                    <a href="/user/php/products-detail.php" class="product-link" style="text-decoration: none;">
                        <img src="/user/image/88d.jpg" class="card-img-top" alt="Vợt cầu lông Yonex">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Vợt cầu lông Yonex Astrox 88D Pro</h5>
                            <p class="card-text price">4,000,000 VND</p>
                            <p class="card-text"><strong>Mô tả:</strong> Yonex Astrox 88D Pro là lựa chọn tuyệt vời cho người chơi tấn công mạnh mẽ.</p>
                            <a href="#" class="btn btn-add-to-cart mt-auto"><i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng</a>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="/user/image/nnf800.jpg" class="card-img-top" alt="Vợt cầu lông Yonex">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Vợt cầu lông Yonex Nanoflare 800</h5>
                        <p class="card-text price">3,500,000 VND</p>
                        <p class="card-text"><strong>Mô tả:</strong> Yonex Nanoflare 800 là lựa chọn tuyệt vời cho người chơi thiên về tốc độ và phản xạ nhanh.</p>
                        <a href="#" class="btn btn-add-to-cart mt-auto"><i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="/user/image/arc11pro.jpg" class="card-img-top" alt="Vợt cầu lông Yonex">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Vợt cầu lông Yonex Arcsaber 11 Pro</h5>
                        <p class="card-text price">4,380,000 VND</p>
                        <p class="card-text"><strong>Mô tả:</strong> Yonex Arcsaber 11 Pro là lựa chọn tuyệt vời cho người chơi kiểm soát trận đấu và phòng thủ ổn định.</p>
                        <a href="#" class="btn btn-add-to-cart mt-auto"><i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="/user/image/duorazstrike.jpg" class="card-img-top" alt="Vợt cầu lông Yonex">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Vợt cầu lông Duora Z-Strike</h5>
                        <p class="card-text price">3,380,000 VND</p>
                        <p class="card-text"><strong>Mô tả:</strong> Yonex Duora Z-Strike là lựa chọn tuyệt vời cho người chơi toàn diện, cần khả năng tấn công mạnh mẽ.</p>
                        <a href="#" class="btn btn-add-to-cart mt-auto"><i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lining -->
        <h3 class="mt-4">Lining</h3>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <div class="col">
                <div class="card h-100">
                    <img src="/user/image/axf100.jpg" class="card-img-top" alt="Vợt cầu lông Lining">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Vợt cầu lông Lining Axforce 100</h5>
                        <p class="card-text price">3,800,000 VND</p>
                        <p class="card-text"><strong>Mô tả:</strong> Lining Axforce 100 là lựa chọn tuyệt vời cho người chơi tấn công mạnh từ cuối sân.</p>
                        <a href="#" class="btn btn-add-to-cart mt-auto"><i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="/user/image/clb900.jpg" class="card-img-top" alt="Vợt cầu lông Lining">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Vợt cầu lông Lining 3D Calibar 900</h5>
                        <p class="card-text price">3,939,000 VND</p>
                        <p class="card-text"><strong>Mô tả:</strong> Lining 3D Calibar 900 là lựa chọn tuyệt vời cho người chơi tấn công với sức mạnh và linh hoạt.</p>
                        <a href="#" class="btn btn-add-to-cart mt-auto"><i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="/user/image/hbt9000.jpg" class="card-img-top" alt="Vợt cầu lông Lining">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Vợt cầu lông Lining Halbertec 9000</h5>
                        <p class="card-text price">4,100,000 VND</p>
                        <p class="card-text"><strong>Mô tả:</strong> Lining Halbertec 9000 là lựa chọn tuyệt vời cho người chơi tấn công cần sự ổn định và kiểm soát.</p>
                        <a href="#" class="btn btn-add-to-cart mt-auto"><i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="/user/image/bladex900moon.jpg" class="card-img-top" alt="Vợt cầu lông Lining">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Vợt cầu lông Lining Bladex 900 Moon</h5>
                        <p class="card-text price">4,080,000 VND</p>
                        <p class="card-text"><strong>Mô tả:</strong> Lining Bladex 900 Moon là lựa chọn tuyệt vời cho người chơi tấn công nhanh và mạnh từ cuối sân.</p>
                        <a href="#" class="btn btn-add-to-cart mt-auto"><i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>