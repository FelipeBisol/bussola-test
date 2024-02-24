## Instalando o Projeto

Para executar o projeto, siga estes passos:

1. Clone o repositório usando o comando:
    - git clone https://github.com/FelipeBisol/bussola-test.git


2. Navegue até o diretório do projeto:
   - cd bussola-test


3. Construa os contêineres usando Docker Compose:
   - docker-compose build


4. Após executar esses comandos, o projeto estará pronto para executar os testes e também o comando para simular uma venda. Para isso, é necessário primeiro iniciar os containers para depois acessá-lo. Você pode fazer isso executando o seguinte comando dentro da pasta raiz do projeto:
    - docker-compose up -d
    - docker-compose exec laravel.test sh

    
5. Agora que você está dentro do contêiner, siga os próximos passos:
    - cp .env.example .env
    - composer install
    - Execute os testes com o comando:
      - php artisan test
    - Simule uma venda com o comando (O comando `php artisan new:order` é usado para simular uma venda, fornecendo apenas um exemplo da funcionalidade de cálculos):
      - php artisan new:order


