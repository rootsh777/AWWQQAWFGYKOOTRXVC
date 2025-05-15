# Usa una imagen oficial con Apache + PHP preinstalado
FROM php:8.2-apache

# Copia tu código fuente al directorio raíz de Apache
COPY . /var/www/html/

# Habilita módulos de Apache si es necesario
RUN docker-php-ext-install mysqli && \
    a2enmod rewrite

# Establece permisos adecuados
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto 80
EXPOSE 80

# El contenedor se inicia con Apache en primer plano
CMD ["apache2-foreground"]