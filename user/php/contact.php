<!-- filepath: d:\xampp\htdocs\LTW2\user\php\contact.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liên hệ</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
  .custom-btn {
    background-color: #000;
    color: #fff;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    transition: all 0.3s ease;
  }

  .custom-btn:hover {
    background-color: #fff;
    color: #000;
    border: 2px solid #000;
  }
</style>

<body>
    <?php include 'header.php'; ?>

    <main class="container mt-5">
      <!-- Tiêu đề -->
      <div class="row text-center mb-5">
        <div class="col-md-12">
          <h1 class="display-4">Liên hệ với chúng tôi</h1>
          <p class="lead">Chúng tôi luôn sẵn sàng hỗ trợ bạn. Hãy liên hệ với chúng tôi qua các kênh sau:</p>
        </div>
      </div>

      <!-- Thông tin liên hệ -->
      <div class="row text-center">
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title">📞 Hotline</h5>
              <p class="card-text">0989 999 999</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title">📧 Email</h5>
              <p class="card-text">contact@badmintonshop.vn</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title">🏢 Địa chỉ</h5>
              <p class="card-text">123 Đường Cầu Lông, Hà Nội</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Form liên hệ -->
      <div class="row mt-5">
        <div class="col-md-8 offset-md-2">
          <h2 class="text-center mb-4">Gửi tin nhắn cho chúng tôi</h2>
          <form>
            <div class="mb-3">
              <label for="name" class="form-label">Họ và tên</label>
              <input type="text" class="form-control" id="name" placeholder="Nhập họ và tên của bạn">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" placeholder="Nhập email của bạn">
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">Tin nhắn</label>
              <textarea class="form-control" id="message" rows="5" placeholder="Nhập tin nhắn của bạn"></textarea>
            </div>
            <button type="submit" class="btn custom-btn w-100">Gửi tin nhắn</button>
          </form>
        </div>
      </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>