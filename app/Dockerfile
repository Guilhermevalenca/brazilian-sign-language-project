FROM docker:latest

RUN apk add --no-cache docker-compose

WORKDIR /app
COPY . .

CMD ["sh", "-c", "docker compose --profile prod up"]
