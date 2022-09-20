DROP TABLE IF EXISTS products;

CREATE TABLE products (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  product_code INT(11) NOT NULL,
  product_name VARCHAR(50) NOT NULL,
  price INT(11) NOT NULL,
  stock_quantity INT(11) NOT NULL,
  vendor_code INT(11) NOT NULL,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (vendor_code) REFERENCES vendors (vendor_code)
);