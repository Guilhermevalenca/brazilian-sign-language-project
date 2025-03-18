# Usa uma imagem oficial do Docker com suporte a Docker Compose
FROM docker:latest

# Instala Docker Compose
RUN apk add --no-cache docker-compose

# Copia os arquivos do Docker Compose para o container
WORKDIR /app
COPY . .

# Comando para rodar o docker-compose
CMD ["sh", "-c", "docker compose --profile prod up"]
