FROM node:alpine as builder
COPY . /app
WORKDIR /app
RUN npm install
RUN npm run production

FROM evilfreelancer/dockavel:latest
COPY . /app
COPY --from=builder /app/public/ /app/public
WORKDIR /app
RUN apk --update --no-cache add php7-mcrypt php7-sodium
RUN chown apache:apache -R bootstrap \
 && chown apache:apache -R storage \
 && composer install \
 && php artisan cache:clear
ENTRYPOINT ["/app/entrypoint.sh"]
