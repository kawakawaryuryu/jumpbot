# centos image
FROM centos:latest

# add yum repo
RUN yum install -y epel-release
RUN rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm

# git install
RUN yum install -y git

# cron install
RUN yum install -y cronie-noanacron

# php install
RUN yum install -y --enablerepo=remi-php71 php

# composer install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# change working directory for ADD instruction
WORKDIR /app

# copy files to /app directory
ADD . /app

# composer install
RUN composer install

# add cron setting to /etc/ctontab
COPY jump-cron /etc/cron.d/

RUN chmod 644 /etc/cron.d/jump-cron

# cron setting
#RUN systemctl restart crond

# execute cron
CMD crond && tail -f /dev/null
