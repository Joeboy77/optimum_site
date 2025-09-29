FROM php:8.1-apache

# Install required PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql \
  && docker-php-ext-enable mysqli pdo_mysql

# Enable Apache modules commonly needed
RUN a2enmod rewrite headers

# Configure PHP
COPY docker/php.ini /usr/local/etc/php/conf.d/zz-oes.ini

# Set working directory and copy app
WORKDIR /var/www/html
COPY . /var/www/html

# Set recommended Apache DocumentRoot
ENV APACHE_DOCUMENT_ROOT=/var/www/html
RUN sed -ri -e 's!/var/www/html!/var/www/html!g' /etc/apache2/sites-available/000-default.conf \
  && sed -ri -e 's!/var/www/!/var/www/!g' /etc/apache2/apache2.conf

# Healthcheck (optional)
HEALTHCHECK --interval=30s --timeout=5s --retries=3 CMD curl -f http://localhost/ || exit 1

EXPOSE 80
