<!-- filepath: d:\xampp\htdocs\LTW2\user\php\about.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giới thiệu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>

  <main class="container mt-5">
    <!-- Phần tiêu đề -->
    <div class="row mb-5">
      <div class="col-md-12 text-center">
        <h1 class="display-4 mb-3">Về chúng tôi</h1>
        <p class="lead">Chúng tôi chuyên cung cấp các sản phẩm cầu lông chất lượng cao, phục vụ nhu cầu của mọi đối tượng khách hàng.</p>
      </div>
    </div>

    <!-- Phần hình ảnh và mô tả -->
    <div class="row align-items-center mb-5">
      <div class="col-md-6 text-center">
        <img src="/image/about-us.png" alt="Về chúng tôi" class="img-fluid rounded shadow w-50">
      </div>
      <div class="col-md-6">
        <h2 class="h4 mb-3">Sứ mệnh của chúng tôi</h2>
        <p class="mb-4">Chúng tôi cam kết mang đến cho khách hàng những sản phẩm tốt nhất với giá cả hợp lý, cùng với dịch vụ chăm sóc khách hàng tận tâm.</p>
        <h2 class="h4 mb-3">Tầm nhìn</h2>
        <p class="mb-4">Trở thành thương hiệu hàng đầu trong lĩnh vực cung cấp dụng cụ cầu lông tại Việt Nam và khu vực.</p>
        <h2 class="h4 mb-3">Giá trị cốt lõi</h2>
        <ul>
          <li>Chất lượng sản phẩm là ưu tiên hàng đầu.</li>
          <li>Khách hàng là trung tâm của mọi hoạt động.</li>
          <li>Đổi mới và sáng tạo không ngừng.</li>
          <li>Trách nhiệm xã hội và bảo vệ môi trường.</li>
        </ul>
      </div>
    </div>

    <!-- Phần liên hệ -->
    <div class="row text-center mb-5">
      <div class="col-md-12">
        <h2 class="display-6 mb-3">Liên hệ với chúng tôi</h2>
        <p class="lead mb-4">Nếu bạn có bất kỳ câu hỏi nào, đừng ngần ngại liên hệ với chúng tôi qua các kênh sau:</p>
      </div>
    </div>
    <div class="row text-center">
      <div class="col-md-4 mb-4">
        <h5>Email</h5>
        <p>support@badmintonstore.com</p>
      </div>
      <div class="col-md-4 mb-4">
        <h5>Hotline</h5>
        <p>+84 123 456 789</p>
      </div>
      <div class="col-md-4 mb-4">
        <h5>Địa chỉ</h5>
        <p>123 Đường ABC, Quận 1, TP. Hồ Chí Minh</p>
      </div>
    </div>
  </main>

  <?php include 'footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>