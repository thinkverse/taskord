FROM gitpod/workspace-mysql

# Instal Requirements
RUN sudo add-apt-repository ppa:ondrej/php -y \
    && sudo apt update -y \
    && sudo apt-get purge apache2* -y \
    && sudo apt install -y \
    redis-server \
    php \
    php-curl \
    php-common \
    php-cli \
    php-mysql \
    php-mbstring \
    php-xml \
    php-zip \
    php-redis \
    php-gd \
    php-bcmath \
    && sudo update-alternatives --set php /usr/bin/php8.0

# Install Composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && HASH=`curl -sS https://composer.github.io/installer.sig` \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
