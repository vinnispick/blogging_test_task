FROM php:8.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set Working Directory
WORKDIR /var/www/html

# Copy composer files for caching
COPY composer.json composer.lock* ./

# Install dependencies without scripts/autoloader for cache optimization
RUN composer install --no-dev --no-scripts --no-autoloader

# Update Apache Config for /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy project files
COPY . /var/www/html

# Finish composer (dump autoloader) and ensure .env exists
RUN composer dump-autoload --optimize --no-dev \
    && cp .env.example .env

# Correct permissions for Smarty and entrypoint
RUN mkdir -p templates_c cache \
    && chmod -R 777 templates_c cache \
    && chmod +x bin/docker-entrypoint.sh

EXPOSE 80

# Use our entrypoint script
ENTRYPOINT ["bin/docker-entrypoint.sh"]
