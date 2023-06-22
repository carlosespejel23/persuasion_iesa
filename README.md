<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## TRIGGERS en la Base De Datos

```bash
DELIMITER //
CREATE TRIGGER generate_slug_trigger BEFORE INSERT ON posts
FOR EACH ROW
BEGIN
  SET NEW.slug = UUID();
  SET NEW.`created_at` = NOW();
  SET NEW.`updated_at` = NOW();
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER users_trigger BEFORE INSERT ON users
FOR EACH ROW
BEGIN
  SET NEW.`created_at` = NOW();
  SET NEW.`updated_at` = NOW();
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER emojis_configs_trigger BEFORE INSERT ON emojis_configs
FOR EACH ROW
BEGIN
  SET NEW.`created_at` = NOW();
  SET NEW.`updated_at` = NOW();
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER deudores_trigger BEFORE INSERT ON deudores
FOR EACH ROW
BEGIN
  SET NEW.`created_at` = NOW();
  SET NEW.`updated_at` = NOW();
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER comentarios_deudas_pagos_trigger BEFORE INSERT ON comentarios_deudas_pagos
FOR EACH ROW
BEGIN
  SET NEW.`created_at` = NOW();
  SET NEW.`updated_at` = NOW();
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER comentarios_actualizar_deudas_trigger BEFORE INSERT ON comentarios_actualizar_deudas
FOR EACH ROW
BEGIN
  SET NEW.`created_at` = NOW();
  SET NEW.`updated_at` = NOW();
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER comentarios_trigger BEFORE INSERT ON comentarios
FOR EACH ROW
BEGIN
  SET NEW.`created_at` = NOW();
  SET NEW.`updated_at` = NOW();
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER insert_emojis_config AFTER INSERT ON users
FOR EACH ROW
BEGIN
  INSERT INTO emojis_configs (usuario_id, enojo, `like`, comentar, compartir)
  VALUES (NEW.id, 'Me Enoja', 'Me Gusta', 'Comentar', 'Compartir');
END //
DELIMITER ;
```