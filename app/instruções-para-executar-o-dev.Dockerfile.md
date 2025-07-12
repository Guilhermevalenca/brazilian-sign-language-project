# comandos para rodar o container

- Obs.: para executar o container, você precisa estar na raiz do projeto
- Obs.: Verifique se o docker compose não está em execução.

## Cria a imagem

```
docker build -t libras-app -f dev.Dockerfile .
```

## Executa o container

```
 docker run -it -p 3000:3000 -v "$PWD":/app --workdir /app libras-app
```

# Outra forma de executar o container:

### Esse comando cria a image e executa o container

```
docker build -t libras-app -f dev.Dockerfile . && docker run -it -p 3000:3000 -v "$PWD":/app --workdir /app libras-app
```

### Quando quiser executar novamente, só precisa executar esse comando

```
docker run -it -p 3000:3000 -v "$PWD":/app --workdir /app libras-app
``` 