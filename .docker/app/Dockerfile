FROM webdevops/php-apache-dev:7.4-alpine

RUN apk update && apk add --update npm

ADD https://github.com/ufoscout/docker-compose-wait/releases/download/2.8.0/wait /wait
RUN chmod +x /wait

CMD /wait && bash -c "cd ./app && composer install && \
  php artisan migrate:fresh && \
  php artisan fruits:fetch && \
  npm i && \
  npm run dev" && supervisord
