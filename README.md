# Notes API

A Notes API é uma API de gerenciamento de notas, onde os usuários podem criar, atualizar, excluir e buscar notas. Cada nota possui um corpo, um status, uma cor de status e um registro de histórico de status.

## Tecnologias Utilizadas

- Laravel 10
- MySQL (ou outro banco de dados compatível)

## Configuração do Ambiente

1. Clone o repositório para a sua máquina local:

```shell
git clone https://github.com/seu-usuario/notes-api.git
```

2. Navegue até o diretório do projeto:

```
cd notes-api
```

3. Instale as dependências do projeto usando o Composer:

```
composer install
```

4. Crie um arquivo `.env` na raiz do projeto e configure as variáveis de ambiente, como as credenciais do banco de dados.

5. Execute as migrações do banco de dados para criar as tabelas necessárias:

```
php artisan migrate
```

6. Inicie o servidor de desenvolvimento:

```
php artisan serve
```

## Uso da API

A API possui as seguintes rotas disponíveis:

- `GET /api/notes`: Retorna todas as notas.
- `POST /api/notes`: Cria uma nova nota.
- `PUT /api/notes/{id}/status`: Atualiza o status de uma nota existente e adiciona ao registro de histórico de status.

### Exemplos de Requisições

#### Criação de uma nova nota

```http
POST /api/notes

{
  "user_id": 1,
  "body": "Conteúdo da nota",
  "status": "ativo",
  "color_status": "#FF0000",
  "status_log": [
    {
      "status": "ativo",
      "timestamp": "2023-05-14 10:00:00"
    }
  ]
}
```

#### Atualização do status de uma nota

```http
PUT /api/notes/1/status

{
  "status": 3
}
```

### Respostas da API

A API retorna as seguintes respostas:

- `200 OK`: Requisição bem-sucedida.
- `201 Created`: Recurso criado com sucesso.
- `204 No Content`: Requisição bem-sucedida, sem conteúdo para retornar.
- `400 Bad Request`: Erro na requisição do cliente.
- `404 Not Found`: Recurso não encontrado.
- `500 Internal Server Error`: Erro interno do servidor.

## Contribuição

Contribuições para o projeto são bem-vindas! Se você encontrar algum problema ou tiver sugestões de melhorias, sinta-se à vontade para abrir uma issue ou enviar um pull request.

## Licença

Este projeto está licenciado sob a [MIT License](https://opensource.org/licenses/MIT).