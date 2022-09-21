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

INSERT INTO products (product_code, product_name, price, stock_quantity, vendor_code) VALUES (
  1, "商品A", 800, 30, 1111
);

INSERT INTO products (product_code, product_name, price, stock_quantity, vendor_code) VALUES (
  2, "商品B", 1000, 50, 2222
);

SELECT * FROM products;