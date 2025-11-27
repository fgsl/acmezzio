# Acmezzio

Projeto desenvolvido para o curso _Introdução a Mezzio com TDD para criação de microsserviços em PHP_ da PHP Conference Brasil 2025.

## Criação do projeto com Mezzio

Para criar um projeto com Mezzio, usamos o [Composer](https://getcomposer.org/). Criamos um projeto chamado acmezzio, um cadastro de equipamentos para coiotes caçarem papa-léguas. O comando de criação foi este:

```shell
composer create-project mezzio/mezzio-skeleton acmezzio
```
## Development mode

No development mode, há um arquivo `development.config.php`, com configurações de desenvolvimento. Você pode controlar o uso desse arquivo com comandos do Composer:

```shell
$ composer development-disable
$ composer development-enable
$ composer development-status
```
## Execução da aplicação

Após clonar a aplicação, você precisa baixar as dependências com o Composer, assim:

```shell
$ composer install
```

Para executar a aplicação criada, basta usar o servidor embutido do PHP:

```shell
$ php -S localhost:8000 acmezzio/public/
```

## Estrutura da aplicação

As rotas da aplicação são definidas no arquivo `config/routes.php`.

Dentro da pasta `src`, de acordo com a opção de criação, foi criada, na geração do projeto, uma subpasta `App`, que é um **módulo**, uma divisão da aplicação que pode conter vários **Request Handlers**.
Um módulo é dividido em duas pastas:
* src: classes PHP
* templates: páginas HTML

As configurações dos módulos são agregadas no arquivo `config/config.php`.

O [PHPUnit](https://phpunit.de/index.html) vem como dependência por padrão.

Você pode executar o PHPUnit e o PHP CodeSniffer de uma vez, com o Composer:

```shell
$ composer check
```

O projeto é criado com testes para os dois **Request Handlers** da aplicação.

## Banco de dados

Neste projeto usamos um banco de dados MySQL/MariaDB, chamado acmezzio, com uma tabela chamada equipment. O script está em `data\acmezzio.sql`.


