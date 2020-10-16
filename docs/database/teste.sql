CREATE SCHEMA IF NOT EXISTS teste DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE teste;

CREATE TABLE IF NOT EXISTS teste.user (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  email TEXT NOT NULL,
  password CHAR(97) NOT NULL,
  created DATETIME NOT NULL,
  PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS teste.category (
  id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX name_UNIQUE (name ASC)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS teste.product (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  category_id SMALLINT UNSIGNED NOT NULL,
  name VARCHAR(120) NOT NULL,
  price DECIMAL(9,2) NOT NULL,
  PRIMARY KEY (id),
  INDEX fk_product_category_idx (category_id ASC),
  CONSTRAINT fk_product_category
    FOREIGN KEY (category_id)
    REFERENCES teste.category (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS teste.sale (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id INT UNSIGNED NOT NULL,
  created DATETIME NOT NULL,
  PRIMARY KEY (id),
  INDEX fk_sale_user1_idx (user_id ASC),
  CONSTRAINT fk_sale_user1
    FOREIGN KEY (user_id)
    REFERENCES teste.user (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS teste.cart (
  sale_id INT UNSIGNED NOT NULL,
  product_id INT UNSIGNED NOT NULL,
  amount SMALLINT UNSIGNED NOT NULL,
  PRIMARY KEY (sale_id, product_id),
  INDEX fk_sale_has_product_product1_idx (product_id ASC),
  INDEX fk_sale_has_product_sale1_idx (sale_id ASC),
  CONSTRAINT fk_sale_has_product_sale1
    FOREIGN KEY (sale_id)
    REFERENCES teste.sale (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_sale_has_product_product1
    FOREIGN KEY (product_id)
    REFERENCES teste.product (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

