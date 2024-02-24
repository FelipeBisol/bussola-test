FROM alpine:latest

# Install packages and remove default server definition
RUN apk --no-cache add \
  curl \
  bash \
  nginx \
  php83 \
  php83-ctype \
  php83-curl \
  php83-dom \
  php83-fpm \
  php83-gd \
  php83-intl \
  php83-json \
  php83-mbstring \
  php83-mysqli \
  php83-pdo_pgsql\
  php83-pdo_mysql \
  php83-pgsql \
  php83-opcache \
  php83-openssl \
  php83-phar \
  php83-session \
  php83-xml \
  php83-xmlreader \
  php83-zlib \
  php83-simplexml\
  php83-pdo\
  php83-soap\
  php83-fileinfo \
  php83-tokenizer\
  php83-xmlwriter\
  php83-pcntl\
  php83-posix\
  php83-iconv\
  php83-zip\
  php83-exif\
  php83-redis \
  supervisor\
  git

# Create symlink so programs depending on `php` still function
RUN ln -s /usr/bin/php83 /usr/bin/php

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Configure nginx
COPY .docker/nginx.conf /etc/nginx/nginx.conf
ADD .docker/default.crt /etc/ssl/certs/laravel.crt
ADD .docker/default.key /etc/ssl/private/laravel.key

# Configure PHP-FPM
COPY .docker/fpm-pool.conf /etc/php83/php-fpm.d/www.conf
COPY .docker/php.ini /etc/php8/conf.d/custom.ini

# Configure supervisord
COPY .docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Setup document root
RUN mkdir -p /var/www/html
RUN mkdir -p /.composer
RUN mkdir -p /.config

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nobody.nobody /var/www/html && \
  chown -R nobody.nobody /run && \
  chown -R nobody.nobody /var/lib/nginx && \
  chown -R nobody.nobody /var/log/nginx  && \
  chown -R nobody.nobody /etc/ssl/certs/ && \
  chown -R nobody.nobody /etc/ssl/private/ && \
  chown -R nobody.nobody /.composer  &&\
  chown -R nobody.nobody /.config

# Switch to use a non-root user from here on
USER nobody

# Add application
WORKDIR /var/www/html
COPY --chown=nobody . /var/www/html/

RUN composer install

# Expose the port nginx is reachable on
EXPOSE 80 443

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1/fpm-ping
