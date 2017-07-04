FROM nginx:latest

RUN apt-get update \
    && apt-get -y install \
    git \
    nano \
    netcat \
    unzip \
    && apt-get clean

COPY docker/site.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www
EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
