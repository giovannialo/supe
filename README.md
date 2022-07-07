# Supe

API para integração com o Sistema Unificado de Processo Eletrônico.

## Dependências

* Docker Compose;
* Rede **mercury-network**;
* Serviço de banco de dados.

## Instalação

Siga as etapas abaixo para um correto funcionamento do sistema.

### Rede mercury-network

Para que a aplicação possa se comunicar com outros containers, como o de banco de dados, por exemplo, crie a rede **mercury-network**.

```docker
docker network create --driver bridge mercury-network
```

### Banco de dados

Se você já tem um serviço de banco de dados rodando, inclua-o na rede **mercury-network**, caso não esteja.

```docker
docker network connect mercury-network nomeDoServicoDeBancoDeDados
```

### Importação do banco de dados

Acesse o SGBD de seu banco de dados e importe o arquivo **/database/dump.sql**.

### Variáveis de ambiente

Renomeei o arquivo .env.example para .env e preencha com os dados solicitados.

```
#
# Domínio
#
HOST=

#
# Banco de dados
# Para utilizar mais de um banco de dados, separe os valores com (;).
# Todas as variáveis, exceto DATABASE_OPTIONS, são de preenchimento obrigatório.
#
DATABASE_KEY=
DATABASE_DRIVER=
DATABASE_HOST=
DATABASE_PORT=
DATABASE_DBNAME=
DATABASE_USERNAME=
DATABASE_PASSWORD=
DATABASE_OPTIONS=1002=SET NAMES utf8mb4&3=2&19=5&8=0

#
# JWT
#
JWT_KEY=
JWT_ALGORITHM=

#
# Supe APi
# Para utilizar mais de um usuário de autenticação, separe os valores com (;).
#
SUPE_API_AUTH_SECRETARY_CODE=
SUPE_API_AUTH_USERNAME=
SUPE_API_AUTH_PASSWORD=
SUPE_API_AUTH_HASH=

# Para a URI /supe/api/v1/processos/redirecionar
SUPE_API_PROTOCOL_SECTOR=

SUPE_API_URL_AUTH=
SUPE_API_URL_PROTOCOL=

# Alguns endpoints de consultas são globais e não diferem de secretarias.
# São endpoints que qualquer usuário válido pode acessar.
# Exemplo /supe/api/v1/secretarias
SUPE_API_DEFAULT_SECRETARY_CODE=
```

### Iniciando o serviço

```docker
docker-compose up -d
```

### Instale os pacotes do composer

```docker
docker exec -it mercury-supe bash -c "composer install"
```

ou

```docker
docker-compose exec mercury-supe composer install
```

## Credits

* [Giovanni Alves de Lima Oliveira](https://github.com/giovannialo) (Developer)
