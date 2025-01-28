FROM php:8.2-fpm

# Symfony deps
RUN apt-get update && apt-get install -y libicu-dev g++ --no-install-recommends && rm -rf /var/lib/apt/lists/* \
 && docker-php-ext-install intl \
 && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false -o APT::AutoRemove::SuggestsImportant=false g++

ENV APCU_VERSION=5.1.23
RUN if [ "$http_proxy" ]; then pear config-set http_proxy "$http_proxy"; fi \
 && pecl install APCu-${APCU_VERSION} && docker-php-ext-enable apcu

RUN { \
        echo 'date.timezone = Europe/Paris'; \
        echo 'short_open_tag = off'; \
        echo 'display_errors = 1'; \
    } | tee /usr/local/etc/php/conf.d/symfony.ini

RUN docker-php-ext-install pdo_mysql

# Composer
RUN ["/bin/bash", "-c", "apt-get update && apt-get install -y git openssh-client unzip --no-install-recommends && rm -rf /var/lib/apt/lists/* \
 && set -o pipefail && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer"]

# npm
ENV NODE_VERSION=18.12.0
RUN curl -L -o /tmp/nodejs.tar.gz https://nodejs.org/dist/v${NODE_VERSION}/node-v${NODE_VERSION}-linux-x64.tar.gz \
 && tar xfvz /tmp/nodejs.tar.gz -C /usr/local --strip-components=1 \
 && rm -f /tmp/nodejs.tar.gz

# yarn
ENV YARN_VERSION=1.22.17
RUN curl -L -o /tmp/yarn.tar.gz https://github.com/yarnpkg/yarn/releases/download/v${YARN_VERSION}/yarn-v${YARN_VERSION}.tar.gz \
 && tar xfvz /tmp/yarn.tar.gz -C /usr/local --strip-components=1 \
 && rm -f /tmp/yarn.tar.gz

RUN apt-get update && apt-get install -y sudo --no-install-recommends && rm -rf /var/lib/apt/lists/* \
 && useradd --system --uid 666 --shell /bin/bash docker-user \
 && { \
        echo 'docker-user ALL=(ALL) NOPASSWD: ALL'; \
        echo 'Defaults:docker-user !env_reset'; \
    } | tee /etc/sudoers.d/docker-user

RUN apt-get update && apt-get install -y acl --no-install-recommends && rm -rf /var/lib/apt/lists/*

COPY docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

ENTRYPOINT ["/docker-entrypoint.sh"]


USER docker-user


WORKDIR /app


CMD ["php-fpm"]
