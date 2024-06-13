# Gestor De Produtos 

## Descrição do Projeto
<p align="center">Api criada para o Desafio Backend da Cellar Vinhos</p>

### Pré-requisitos

Antes de começar, você vai precisar ter instalado em sua máquina as seguintes ferramentas:
[Git](https://git-scm.com), [Docker](https://www.docker.com/), [Docker Compose](https://docs.docker.com/compose/), [Make](https://howtoinstall.co/pt/make), 
Além disso é bom ter um editor para trabalhar com o código como [VSCode](https://code.visualstudio.com/)

### 🎲 Rodando o Back End (servidor)

```bash
# Clone este repositório
$ git clone # Gestor De Produtos 

### 🎲 Rodando o Back End (servidor)

```bash
# Clone este repositório
$ git@github.com:Theel123/gestorDeProdutos.git

# Acesse a pasta do projeto no terminal/cmd
$ cd gestorDeProdutos

# Rode os seguintes comandos
$ make setup-local
$ make local-serve
$ docker exec -it gestor_application bash
$ php artisan migrate --seed

```
# O servidor inciará na porta:9011 - acesse <http://localhost:9011>

# Documentação escrita com mais detalhes sobre a aplicação
```
https://docs.google.com/document/d/1G3JV4RmI5wsRCrFi3lgA8ChQrKwdELlAM5GFa_6kjt0/edit

```
# Documentação Swagger
```
http://localhost:9011/api/documentation#/
http://localhost:9011/docs/api-docs.json

