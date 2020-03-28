# Frontend
FROM node:alpine as builder
COPY . /app
WORKDIR /app
RUN npm install
RUN npm run production

# Backend
FROM evilfreelancer/dockavel:latest
ENV DB_CONNECTION=mysql
ENV DB_HOST=mariadb
ENV DB_PORT=3306
ENV DB_DATABASE=testdb
ENV DB_USERNAME=test_user
ENV DB_PASSWORD=test_pass
COPY . /app
COPY --from=builder /app/public/ /app/public
WORKDIR /app
RUN cp .env.example .env \
 && chown www-data:www-data -R bootstrap \
 && chown www-data:www-data -R storage \
 && composer install --no-dev \
 && php artisan optimize:clear \
 && php artisan lang:js \
 && php artisan key:generate --force

ENTRYPOINT ["/app/entrypoint.sh"]
