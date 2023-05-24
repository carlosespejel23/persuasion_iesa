<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## TRIGGER en la Base De Datos

Para crear un posts en la base de datos, necesitamos agregar un TRIGGER para crear un token para poder compartir ese post

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
```