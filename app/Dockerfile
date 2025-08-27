FROM node:20-alpine

WORKDIR /app

COPY . /app

RUN pnpm install

RUN pnpm build

EXPOSE 3000

CMD ["pnpm", "preview"]