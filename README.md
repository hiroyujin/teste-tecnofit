# Teste Tecnofit
Sistema desenvolvido em PHP com o framework Laravel

## Setup com Docker

Usando o docker a aplicação fica disponível na porta 3000 e o banco na porta 3306

na raiz do projeto execute o comando `make setup`

Obs: Caso seu sistema não seja o linux prefira seguir os passos abaixo, ou altere o tempo de sleep no Makefile para 60 segundos pois docker é mais lento em outros sistemas e não finaliza o processo de setup inicial antes de passar para o proximo passo.


- 1 - Copie o arquivo .env.example para .env
```
cp .env.example .env
```
- 2 - Crie um volume para o mariadb
```
docker volume create --label tecnofit_mariadb --name tecnofit_mariadb
```
- 3 - Rode o seguinte comando para criar os containers
```
docker-compose up -d
```
- 4 - Espere uns 15 segundo para que termine o processo inicial de setup, você pode acompanhar o progresso rodando o comando
```
docker logs -f tecnofit-application
```
- 5 - Execute o seguinte comando para gerar a chave da aplicação
```
docker exec tecnofit-application php artisan key:generate
```
- 6 - Assim que finalizar é necessário rodar o seeder do banco de dados com o comando
```
docker exec tecnofit-application php artisan db:seed
```

Para remover todos os containers e volume basta executar o comando `make destroy`

## Setup sem Docker
### Requisitos
- PHP 7.3+
- Composer
- Banco de dados MySQL

### Setup
- 1 - Copie o arquivo .env.example para .env
```
cp .env.example .env
```
- 2 - No arquivo .env altere os dados de acesso ao banco de dados
DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME e DB_PASSWORD
- 3 - Dentro da raiz do projeto rode os seguintes comandos no terminal
```
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```

## Endpoint movement

### Request

`GET /api/movement/{id}`

### Response
```
{
  movement: 'Movement name',
  ranking: [
    {
      position: 1,
      name: "user name",
      record: 190,
      date: "2021-01-02 00:00:00"
    },
    {
      position: 2,
      name: "user name",
      record: 130,
      date: "2021-01-04 00:00:00"
    }
  ]
}
```

Caso haja alterações nos dados direto pelo banco é necessário desabilitar o cache dentro do arquivo `/app/Services/MovementService`