<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: admin.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Quản trị</title>
  <style>
   body {
  font-family: 'Segoe UI', sans-serif;
  background: #f4f6f9;
  margin: 0;
  padding: 0;
}

header {
  background-color: #2c3e50;
  color: #fff;
  height: 60px; /* fix height để đồng bộ */
  padding: 0 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 999;
}

header h1 {
  margin: 0;
  font-size: 22px;
}

header button {
  padding: 8px 15px;
  background-color: crimson;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
}

.sidebar {
  position: fixed;
  top: 60px; /* trùng với chiều cao header */
  left: 0;
  width: 220px;
  height: calc(100% - 60px);
  background: #34495e;
  padding-top: 20px;
  overflow-y: auto;
}

.sidebar a {
  display: block;
  color: white;
  padding: 12px 20px;
  text-decoration: none;
  font-weight: bold;
  transition: background 0.3s;
}

.sidebar a:hover {
  background-color: #3c5974;
}

.container {
  margin-left: 240px;
  padding: 80px 40px 40px 40px; /* đẩy nội dung tránh header */
  background: #fff;
  border-radius: 8px;
}

h2 {
  border-bottom: 2px solid #007bff;
  padding-bottom: 5px;
  color: #007bff;
  margin-top: 40px;
}

form input, form select, form button {
  display: block;
  width: 100%;
  max-width: 500px;
  padding: 10px;
  margin-bottom: 15px;
  border-radius: 5px;
  border: 1px solid #ccc;
}

form button {
  background: #007bff;
  color: white;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.3s;
}

form button:hover {
  background: #0056b3;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th, td {
  padding: 12px;
  border: 1px solid #ccc;
  text-align: left;
}

th {
  background: #007bff;
  color: white;
}

.action-btn {
  padding: 6px 10px;
  border: none;
  border-radius: 4px;
  color: white;
  cursor: pointer;
  margin-right: 5px;
}

.edit-btn { background: orange; }
.delete-btn { background: red; }
.gray-btn { background: gray; }

.search-input {
  width: 100%;
  max-width: 400px;
  padding: 10px;
  margin: 10px 0 20px;
  border-radius: 5px;
  border: 1px solid #ccc;
}

img {
  max-width: 60px;
}

  </style>
</head>
<body>
  <header>
    <h1>Admin</h1>
    <button onclick="window.location.href='logout.php'">Đăng xuất</button>
  </header>

  <div class="sidebar">
    <a href="#add-user">➕ Thêm người dùng</a>
    <a href="#list-user">👤 Danh sách người dùng</a>
    <a href="#add-product">📦 Thêm sản phẩm</a>
    <a href="#list-product">📃 Danh sách sản phẩm</a>
  </div>

  <div class="container">
  <section id="add-user">
      <h2>➕ Thêm người dùng</h2>
      <form id="addUserForm">
        <input type="text" id="newUsername" placeholder="Tên người dùng" required />
        <input type="email" id="newEmail" placeholder="Email" required />
        <button type="submit">Thêm</button>
      </form>
    </section>

    <section id="list-user">
      <h2>👤 Danh sách người dùng</h2>
      <table id="userTable">
        <thead>
          <tr>
            <th>Tên</th>
            <th>Email</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </section>
    <section id="add-product">
      <h2>📦 Thêm sản phẩm</h2>
      <form id="addProductForm" enctype="multipart/form-data">
        <input type="text" id="productName" placeholder="Tên sản phẩm" required />
        <select id="productCategory">
          <option value="Thời trang">Thời trang</option>
          <option value="Vợt">Vợt</option>
          <option value="Phụ kiện">Phụ kiện</option>
        </select>
        <input type="file" id="productImage" accept="image/*" />
        <button type="submit">Thêm sản phẩm</button>
      </form>
    </section>

    <section id="list-product">
      <h2>📃 Danh sách sản phẩm</h2>
      <input type="text" id="searchInput" class="search-input" placeholder="🔍 Tìm theo tên..." onkeyup="searchProduct()">
      <table id="productTable">
        <thead>
          <tr>
            <th>Tên</th>
            <th>Phân loại</th>
            <th>Hình ảnh</th>
            <th>Đã bán</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </section>
    </div> <!-- Đóng container -->

<script>
  // === NGƯỜI DÙNG ===
  function loadUsers() {
    fetch("user_list.php")
      .then(res => res.json())
      .then(data => {
        const tbody = document.querySelector("#userTable tbody");
        tbody.innerHTML = "";
        data.forEach(user => {
          const row = document.createElement("tr");
          row.innerHTML = `
            <td>${user.username}</td>
            <td>${user.email}</td>
            <td class="status">${user.status}</td>
            <td>
              <button class="action-btn edit-btn" onclick="editUser(${user.id}, this)">Sửa</button>
              <button class="action-btn delete-btn" onclick="deleteUser(${user.id})">Xoá</button>
              <button class="action-btn gray-btn" onclick="toggleUser(${user.id}, this)">
                ${user.status === 'active' ? 'Khoá' : 'Mở khoá'}
              </button>
            </td>
          `;
          tbody.appendChild(row);
        });
      });
  }

  document.getElementById("addUserForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData();
    formData.append("username", document.getElementById("newUsername").value);
    formData.append("email", document.getElementById("newEmail").value);

    fetch("add_user.php", {
      method: "POST",
      body: formData,
    }).then(() => {
      this.reset();
      loadUsers();
    });
  });

  function editUser(id, btn) {
    const row = btn.closest("tr");
    const name = prompt("Tên mới:", row.cells[0].textContent);
    const email = prompt("Email mới:", row.cells[1].textContent);
    if (name && email) {
      const formData = new FormData();
      formData.append("id", id);
      formData.append("username", name);
      formData.append("email", email);
      fetch("edit_user.php", {
        method: "POST",
        body: formData
      }).then(() => loadUsers());
    }
  }

  function deleteUser(id) {
    if (confirm("Bạn có chắc muốn xoá người dùng này?")) {
      const formData = new FormData();
      formData.append("id", id);

      fetch("delete_user.php", {
        method: "POST",
        body: formData
      })
      .then(res => res.text())
      .then(msg => {
        alert(msg);
        loadUsers();
      });
    }
  }

  function toggleUser(id, btn) {
    const row = btn.closest("tr");
    const currentStatus = row.querySelector(".status").textContent.trim();
    const newStatus = (currentStatus === "active") ? "locked" : "active";

    const formData = new FormData();
    formData.append("id", id);
    formData.append("status", newStatus);

    fetch("toggle_user.php", {
      method: "POST",
      body: formData
    }).then(() => loadUsers());
  }

  // === SẢN PHẨM ===
  function loadProducts() {
    fetch("product_list.php")
      .then(res => res.json())
      .then(data => {
        const tbody = document.querySelector("#productTable tbody");
        tbody.innerHTML = "";
        data.forEach(p => {
          const row = document.createElement("tr");
          row.innerHTML = `
            <td>${p.name}</td>
            <td>${p.category}</td>
            <td><img src="uploads/${p.image}" width="60"></td>
            <td class="sold">${p.sold == 1 ? "✔️" : "❌"}</td>
            <td>
              <button class="action-btn edit-btn" onclick="editProduct(${p.id}, this)">Sửa</button>
              <button class="action-btn delete-btn" onclick="deleteProduct(${p.id}, ${p.sold})">Xoá</button>
              <button class="action-btn gray-btn" onclick="toggleSold(${p.id}, this)">
                ${p.sold == 1 ? "Hoàn lại" : "Đã bán"}
              </button>
            </td>
          `;
          tbody.appendChild(row);
        });
      });
  }

  document.getElementById("addProductForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const form = document.getElementById("addProductForm");
    const formData = new FormData(form);
    formData.append("name", document.getElementById("productName").value);
    formData.append("category", document.getElementById("productCategory").value);
    formData.append("image", document.getElementById("productImage").files[0]);

    fetch("add_product.php", {
      method: "POST",
      body: formData
    }).then(() => {
      form.reset();
      loadProducts();
    });
  });

  function editProduct(id, btn) {
    const row = btn.closest("tr");
    const name = prompt("Tên mới:", row.cells[0].textContent);
    const category = prompt("Phân loại mới:", row.cells[1].textContent);
    if (name && category) {
      const formData = new FormData();
      formData.append("id", id);
      formData.append("name", name);
      formData.append("category", category);
      fetch("edit_product.php", {
        method: "POST",
        body: formData
      }).then(() => loadProducts());
    }
  }

  function deleteProduct(id, sold) {
    if (sold == 1) {
      alert("Không thể xoá sản phẩm đã bán, sẽ ẩn thay thế.");
    }
    if (confirm("Bạn có chắc muốn xoá sản phẩm này?")) {
      const formData = new FormData();
      formData.append("id", id);
      fetch("delete_product.php", {
        method: "POST",
        body: formData
      }).then(() => loadProducts());
    }
  }

  function toggleSold(id, btn) {
    const row = btn.closest("tr");
    const soldCell = row.querySelector(".sold");
    const isSold = soldCell.textContent === "✔️";
    const newSold = isSold ? 0 : 1;

    const formData = new FormData();
    formData.append("id", id);
    formData.append("sold", newSold);

    fetch("toggle_sold.php", {
      method: "POST",
      body: formData
    }).then(() => loadProducts());
  }

  function searchProduct() {
    const keyword = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("#productTable tbody tr");
    rows.forEach(row => {
      const name = row.cells[0].textContent.toLowerCase();
      row.style.display = name.includes(keyword) ? "" : "none";
    });
  }

  window.onload = function () {
    loadUsers();
    loadProducts();
  };
</script>
</body>
</html>
