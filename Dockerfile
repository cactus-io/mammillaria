# Dockerfile
#
# SEE: https://github.com/docker-library/php/blob/67efd89c36bf15cb5ba096213e0536b2cab5eb38/7.2/stretch/apache/Dockerfile
#
FROM php:7.2-apache

###########################################################
# Build process
###########################################################
RUN apt-get update
	

RUN docker-php-source extract

RUN docker-php-ext-install ctype
#RUN docker-php-ext-install openssl
RUN docker-php-ext-enable ctype

# JSON (is loaded)
RUN docker-php-ext-install json
RUN docker-php-ext-install mbstring
RUN docker-php-ext-enable json mbstring

# DB MySQL
RUN docker-php-ext-install mysqli
#RUN docker-php-ext-install mysqlnd
#RUN docker-php-ext-install sqlite3 
RUN docker-php-ext-enable mysqli

#RUN docker-php-ext-install libxml
#RUN docker-php-ext-install xml 
#RUN docker-php-ext-install xmlreader 
#RUN docker-php-ext-install xmlwriter 
#RUN docker-php-ext-install SimpleXML 

# Support ZIP
RUN echo "deb http://http.debian.net/debian jessie-backports main" > /etc/apt/sources.list.d/jessie-backports.list
RUN apt-get install --no-install-recommends -y zlib1g-dev zip unzip


RUN docker-php-ext-install zip 
#RUN docker-php-ext-install zlib 
RUN docker-php-ext-enable zip

# Support CURL
#RUN apt-get install --no-install-recommends -y curl
#RUN docker-php-ext-install curl

#RUN docker-php-ext-install bz2
#RUN docker-php-ext-install date
#RUN docker-php-ext-install dom
#RUN docker-php-ext-install filter 
#RUN docker-php-ext-install gettext
#RUN docker-php-ext-install hash
#RUN docker-php-ext-install iconv
#RUN docker-php-ext-install pcntl
#RUN docker-php-ext-install pcre

# Graphics
#RUN docker-php-ext-install gd 
#RUN docker-php-ext-enable gd

# PDO
#RUN docker-php-ext-install PDO 
#RUN docker-php-ext-install pdo_mysql 
#RUN docker-php-ext-install pdo_sqlite 

#RUN docker-php-ext-install Phar 
#RUN docker-php-ext-install Reflection 
#RUN docker-php-ext-install session 
#RUN docker-php-ext-install SPL 
#RUN docker-php-ext-install standard 
#RUN docker-php-ext-install tokenizer 


WORKDIR /var/www/
# Add composer
RUN apt-get install --no-install-recommends -y git
WORKDIR /var/www/html/
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"


WORKDIR /var/www/html/
ENV COMPOSER_ALLOW_SUPERUSER 1
COPY composer.json /var/www/html/
RUN php composer.phar install --no-dev --no-plugins --no-scripts --optimize-autoloader
ENV COMPOSER_ALLOW_SUPERUSER 0

# files
COPY storage/ /var/www/storage/
RUN chmod 777 /var/www/storage/

COPY run.sh /var/www/
RUN chmod +x /var/www/run.sh

COPY index.php /var/www/html/
COPY config.php /var/www/html/
COPY urls.php /var/www/html/
COPY .htaccess /var/www/html/
COPY ./Cactus /var/www/html/Cactus/

# Remove unused
RUN rm -rf /var/lib/apt/lists/\*
RUN docker-php-source delete

# Change directory to the html
WORKDIR /var/www/html
CMD ["/var/www/run.sh"]

# Disable Apache access.log
RUN rm /var/log/apache2/access.log

# enable PHP mode
RUN a2enmod rewrite
#RUN a2enmod zlib
#RUN a2enmod gzip



