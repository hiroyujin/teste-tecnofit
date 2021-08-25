# Teste Tecnofit
Sistema desenvolvido em PHP com o framework Laravel

## Setup com docker
na raiz do projeto rode o comando `make setup`
ou siga as seguintes instruções:
- 1 - Crie um volume para o mariadb
```
docker volume create --label tecnofit_mariadb --name tecnofit_mariadb
```
- 2 - Rode o seguinte comando para criar os containers
```
docker-compose up -d
```
- 3 - Espere uns 15 segundo para que termine o processo inicial de setup, você pode acompanhar o progresso rodando o comando
```
docker logs -f tecnofit-application
```
- 4 - Assim que finalizar é necessário rodar o seeder do banco de dados com o comando
```
docker exec tecnofit-application php artisan db:seed
```

## Setup sem docker

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