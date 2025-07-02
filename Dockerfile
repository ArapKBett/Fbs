# Use official PHP image with Apache
FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libonig-dev \
    && docker-php-ext-install pdo mbstring

# Copy project files to Apache's web root
WORKDIR /var/www/html
COPY . .

# Set permissions for data directory
RUN chown -R www-data:www-data /var/www/html/data \
    && chmod -R 755 /var/www/html \
    && chmod 600 /var/www/html/data/stolen_data.txt

# Configure Apache to use port defined by Render (default 10000)
ENV APACHE_PORT 10000
RUN sed -i "s/80/${APACHE_PORT}/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Expose the port
EXPOSE ${APACHE_PORT}

# Start Apache
CMD ["apache2-foreground"]
