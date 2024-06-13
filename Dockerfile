
FROM wyveo/nginx-php-fpm:php81

COPY . /usr/share/nginx/html
COPY ./nginx/nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /usr/share/nginx/html

RUN ln -s public html

RUN apt update; \
    apt install nano -y 

RUN apt-get clean && rm -rf /var/lib/apt/lists/*    

EXPOSE 80