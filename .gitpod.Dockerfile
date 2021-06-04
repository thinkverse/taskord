FROM gitpod/workspace-mysql

RUN apt-get update
RUN apt-get install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt-get update
RUN apt-get install -y php php-tidy php-bcmath php-curl php-xml php-mbstring php-intl php-mysql
RUN apt-get clean
