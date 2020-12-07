# Dockerfile
#
# SEE: https://github.com/docker-library/php/blob/67efd89c36bf15cb5ba096213e0536b2cab5eb38/7.2/stretch/apache/Dockerfile
# SEE: https://hub.docker.com/layers/php/library/php/7.4.5-apache/images/sha256-f615d3f76fd98e1dde792e4ad514175d652e18c9d3400c94783d0c10354bbc95?context=explore
#
FROM php:7.4.11-apache
LABEL MAINTAINER ViraWeb123 (info@viraweb123.com)

####################################################
# Update os
# Installl all required applications
####################################################
RUN apt-get update \
	&& apt-get install -y --no-install-recommends \
		libonig-dev \
		libzip-dev \
		curl \
		zlib1g-dev \
		zip \
		unzip \
		git \
	####################################################
	# Prepaire source
	####################################################
	&& docker-php-source extract  \
	# Install extensions
	&& docker-php-ext-install bcmath \
	&& docker-php-ext-install mysqli \
	&& docker-php-ext-install pdo_mysql \
	####################################################
	# Imagick
	####################################################
	&& apt-get install -y libmagickwand-dev --no-install-recommends \
	&& cd /tmp \
	&& git clone https://github.com/mkoppanen/imagick.git \
	&& cd imagick \ 
	&& phpize \
	&& ./configure \
	&& make \
	&& make install \
	&& docker-php-ext-enable imagick \
	####################################################
	# Enable extensions
	####################################################
	&& a2enmod rewrite \
	####################################################
	# remove chache 
	####################################################
	&& docker-php-source delete \
	# && apt-get autoremove --purge lib*-dev -y \
	&& rm -fR /tmp/* \
	&& rm -rf /var/lib/apt/lists/\* 

####################################################
# Environment
####################################################
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_ALLOW_SUPERUSER 0

####################################################
# Installl composer
####################################################
COPY ./assets/composer.json /var/www/
RUN cd /var/www/ \
	&& mkdir /var/www/storage/ \
	&& mkdir /var/www/logs/ \
	&& php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
	&& php composer-setup.php \
	&& php composer.phar install --no-plugins --no-scripts \
	&& rm -f composer.phar \
		composer-setup.php
	
####################################################
# copy files
####################################################
COPY ./assets/mime.types /var/www/etc/
COPY ./assets/php.ini "$PHP_INI_DIR/php.ini"
RUN mkdir /var/www/bin
COPY ./assets/generate-token /var/www/bin
RUN chmod +x /var/www/bin/generate-token
COPY html/ /var/www/html/

# Change directory to the html
WORKDIR /var/www/html


