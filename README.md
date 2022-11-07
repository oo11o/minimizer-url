### Fast start
command: 
```
    make start
```


<a href="https://asciinema.org/a/rd1Tmzcmqa1qUMU9wj6My1WZE"><img src="https://asciinema.org/a/rd1Tmzcmqa1qUMU9wj6My1WZE.svg" width="836"/></a>

```
    Makefile desctiption
    -start:
        docker-compose -f docker-compose.yml up -d --build
        sleep 3s
        php bin/console doctrine:database:create
        php bin/console make:migration
        php bin/console doctrine:migrations:migrate
        symfony server:start


```
```
    PHP 7.4
    PostgreSQL alphine last
    Bootsrap 5 CDN
    
    Generator: recursion with lookup in db

```

```
HTTP RESPONSE

| REDIRECT           | HTTP CODE
| /{shortUrl}        |
| -------------------|-------------
| Short URL not find | 404
| Short URL timeout  | 404
| Short URL in time  | 302
|                    |
|                    |
| STATISTIC          |
| /statistic/{id}    |
| -------------------|-------------
| Short URL timeout  | 200
| Short URL in time  | 200
```


```
TABLES

| STATUS             |  
| -------------------|-------------
| id                 | BIGINT
| url                | TEXT
| short_url          | VARCHAR(5)
| expire             | TIMESTAMP
| number_redirect    | INT
| created_at         | TIMESTAMP
| updated_at         | TIMESTAMP

```
