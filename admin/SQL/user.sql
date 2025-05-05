CREATE TABLE IF NOT EXISTS ad_users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(100) DEFAULT '123',
  status ENUM('active','locked') DEFAULT 'active'
);
