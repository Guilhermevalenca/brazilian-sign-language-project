FROM node:22-alpine

WORKDIR /app

EXPOSE 3000

CMD ["sh", "-c", "yarn install && yarn dev"]

# comandos para rodar o container
# cria a imagem
# docker build -t libras-app -f dev.Dockerfile .
# executa o container
# docker run -it -p 3000:3000 -v "$PWD":/app --workdir /app libras-app

# para executar tudo junto:
# docker build -t libras-app -f dev.Dockerfile . && docker run -it -p 3000:3000 -v "$PWD":/app --workdir /app libras-app
