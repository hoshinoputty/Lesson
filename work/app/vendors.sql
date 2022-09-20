DROP TABLE IF EXISTS vendors;

CREATE TABLE vendors (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  vendor_code INT(11) NOT NULL UNIQUE,
  vendor_name VARCHAR(50) NOT NULL
);