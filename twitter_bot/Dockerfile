# centos image
FROM centos:latest

# add yum repo
RUN yum install -y epel-release
RUN rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm

# git install
RUN yum install -y git

# cron install
RUN yum install -y cronie-noanacron

# unzip
RUN yum install -y unzip

# php install
RUN yum install -y --enablerepo=remi-php71 php php-xml php-mbstring php-pdo php-mysqlnd

# composer install
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

# change working directory for ADD instruction
WORKDIR /app

# composer install previously(for using cache)
COPY composer.json /app
COPY composer.lock /app
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN composer install --no-scripts

# copy files to /app directory
COPY . /app

# add cron setting to /etc/ctontab
COPY jump-cron /etc/cron.d/

RUN chmod 644 /etc/cron.d/jump-cron

# cron setting
#RUN systemctl restart crond

# set env variables and execute cron
CMD env > /etc/environment && crond && tail -f /dev/null
