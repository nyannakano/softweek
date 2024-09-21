## Softweek 2024

### 1. Introdução

Este repositório contém o código fonte do projeto Softweek 2024, desenvolvido para o evento Softweek 2024, organizado pela faculdade Campo Real.

### 2. Tecnologias

O projeto foi desenvolvido utilizando as seguintes tecnologias:

- Laravel 11
- Vue.js 3
- Tailwind
- Docker
- MySQL

### 3. Instalação

Para instalar o projeto, siga os passos abaixo:

1. Clone o repositório
2. Execute o comando `./vendor/bin/sail up -d` para subir o ambiente Docker
3. Execute o comando `./vendor/bin/sail artisan migrate` para rodar as migrations
4. Execute o comando `./vendor/bin/sail npm install` para instalar as dependências do front-end
5. Execute o comando `./vendor/bin/sail npm run dev` para compilar os assets
6. Acesse o projeto em `http://localhost`
