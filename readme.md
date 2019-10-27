# Desafio Neoway

A solução do desafio foi desenvolvida utilizando Lumen, MongoDB e ReactJS. 

## Requisitos

Antes de continuar é necessário que tenha docker, docker-compose e make instalados.

## Instalação


A instalação é através do makefile, após clonar o repositório, basta executar:

```bash
git checkout dev
```

```bash
make up
```

## Rotas API

Document
```
Cadastrar - POST    http://localhost:8888/api/v1/documents
Detalhes  - GET     http://localhost:8888/api/v1/documents/{id}
Atualizar - PUT     http://localhost:8888/api/v1/documents/{id}
Listar    - GET     http://localhost:8888/api/v1/documents
Cadastrar na blacklist - POST    http://localhost:8888/api/v1/documents/blacklist/add/{id}
Remover da blacklist - POST    http://localhost:8888/api/v1/documents/blacklist/del/{id}
Detalhes com validação CPF  - GET     http://localhost:8888/api/v1/documents/{cpf}/cpf
Detalhes com validação CNPJ - GET     http://localhost:8888/api/v1/documents/{cnpj}/cnpj

Status UPTime  - GET     http://localhost:8888/api/v1/status
```

## Detalhes do projeto

O frontend pode ser acessado via http://localhost/. 

## Testes Unitários

Para executar o teste unitário deve-se setar a variável de ambiente APP_ENV como testing no arquivo .env:

```
APP_ENV=testing
```
*obs: com a troca DB houve uns contratempos com os testes unitários e não houve tempo suficiente p resolver.

## Postman collections 

O arquivo **Neoway-teste.postman_collection.json** na raiz possui as rotas utilizadas durante o desenvolvimento