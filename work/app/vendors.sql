DROP TABLE IF EXISTS vendors;

CREATE TABLE vendors (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  vendor_code INT(11) NOT NULL UNIQUE,
  vendor_name VARCHAR(50) NOT NULL
);

INSERT INTO vendors (vendor_code, vendor_name) VALUES (
  1111, "仕入れ先A"
);

INSERT INTO vendors (vendor_code, vendor_name) VALUES (
  2222, "仕入れ先B"
);

SELECT * FROM vendors;