# Frontend
FROM node:alpine as builder
COPY . /app
WORKDIR /app
RUN npm install
RUN npm run production

# Backend
FROM evilfreelancer/dockavel:latest
COPY . /app
COPY --from=builder /app/public/ /app/public
WORKDIR /app
RUN cp .env.example .env \
 && touch /app/storage/oauth-private.key \
 && touch /app/storage/oauth-public.key \
 && chown apache:apache -R bootstrap \
 && chown apache:apache -R storage \
 && composer install --no-dev \
 && php artisan optimize:clear \
 && php artisan key:generate --force

ENTRYPOINT ["/app/entrypoint.sh"]
