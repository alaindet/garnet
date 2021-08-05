FROM composer:2.1

RUN addgroup -g 1000 composer && \
    adduser -G composer -g composer -s /bin/sh -D composer

# Production
# RUN composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --classmap-authoritative

WORKDIR /home/composer/app

ENTRYPOINT [ "composer", "--ignore-platform-reqs" ]
