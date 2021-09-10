# Objective Solutions

Resolução do desafio. Framework usado: [Laravel Zero](https://laravel-zero.com/).

## Como rodar o jogo

Primeiro você precisa ter o [Docker](https://www.docker.com/) instalado na sua máquina. Caso ainda não tenha ele, [clique aqui](https://docs.docker.com/get-started/#download-and-install-docker).

Após ter o Docker na sua máquina, você pode executar os seguintes comandos:

```shell
# Criar imagem
docker build -t objective/challenge .

# Rodar o jogo
docker run -it --rm objective/challenge play
```

## Testar

Após criado a imagem, execute:

```shell
docker run -it --rm objective/challenge test
```
