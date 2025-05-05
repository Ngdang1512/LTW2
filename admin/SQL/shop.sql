CREATE DATABASE shop;
USE shop;

CREATE TABLE ad_orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_name VARCHAR(100),
  order_date DATE,
  address TEXT,
  status VARCHAR(50)
);

INSERT INTO ad_orders (customer_name, order_date, address, status)
VALUES
('Nguyễn Văn A', '2025-05-01', 'Hà Nội', 'pending'),
('Trần Thị B', '2025-05-02', 'TP.HCM', 'confirmed'),
('Lê C', '2025-05-03', 'Đà Nẵng', 'success');
