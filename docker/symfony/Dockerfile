FROM php:latest

# Add symfony.ini
COPY php.ini /usr/local/src/php/

# Install extensions
RUN docker-php-ext-install \
    mbstring \
    mysqli \
    pdo_mysql \
    opcache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Run
ENTRYPOINT ["bin/console", "server:run", "0.0.0.0:80"]

# Expose ports
EXPOSE 80
