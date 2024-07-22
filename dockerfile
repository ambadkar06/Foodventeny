FROM php:7.4-apache


# Install PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Install any required packages
RUN apt-get update && apt-get install -y \
    vim \
    && rm -rf /var/lib/apt/lists/*

# Set ServerName to suppress warnings
RUN echo 'ServerName localhost' >> /etc/apache2/apache2.conf

# Copy your application files
COPY src/ /var/www/html/
