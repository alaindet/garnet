FROM node:16 AS development

WORKDIR /home/node/app

COPY package*.json ./

RUN npm install

COPY ./backend .

FROM development AS production

ENV NODE_PATH=./dist
ENV NODE_ENV=production

RUN npm run build
