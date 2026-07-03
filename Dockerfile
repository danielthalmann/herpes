FROM dunglas/frankenphp:latest-php8.3 AS base

# Install php extension
RUN install-php-extensions pdo_sqlite gd curl imap mbstring xml zip bcmath soap intl opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Install Node.js for Vite (development only)
RUN curl -fsSL https://deb.nodesource.com/setup_24.x | bash - \
    && apt-get install -y nodejs

# install crontab, git, ps, wkhtmltopdf
RUN apt-get update && apt-get -y install git procps cron wkhtmltopdf

ADD cronjob /etc/cronjob
RUN chmod 0744 /etc/cronjob && crontab /etc/cronjob

# Expose ports
EXPOSE 80
EXPOSE 443

ENV SERVER_NAME=:80


# FROM base AS production

# Set working directory
# WORKDIR /app

# Copy all application files
# COPY --chown=www-data:www-data . .

# RUN composer install

# ENTRYPOINT [ "/app/entrypoint.sh" ]

# CMD [ "--config", "/etc/caddy/Caddyfile", "--adapter", "caddyfile" ]
