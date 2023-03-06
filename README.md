# builders-pay

API desenvolvida em Laravel para consulta e cálculo de valor e juros de um boleto.

Versões:

PHP: ^8.1<br>
composer: 2.3.10<br>
Laravel Framework: ^10.0

# Instalação do projeto

Realize o clone do projeto através do link https://github.com/evertonalmeida16/builders-pay.git

Para o desenvolvimento do projeto foi utilizado o Framework Laravel, para realizar a configuração inicial do projeto é necessário realizar a instalação de um projeto Laravel. Documentação de instalação https://laravel.com/docs/10.x/installation.

Após realizar o clone do projeto é necessário realizar a configuração e instalação do mesmo, na pasta no projeto, copie o arquivo .env.example e nomei-o para .env, dentro desse arquivo está todas as variáveis de ambiente do projeto, substitua as seguintes váriaveis de banco pelas configurações do seu banco local novo criado do zero:

DB_CONNECTION=mysql<br>
DB_HOST=127.0.0.1<br>
DB_PORT=3306<br>
DB_DATABASE=builders_pay<br>
DB_USERNAME=root<br>
DB_PASSWORD=root

Script para criação de banco de dados utilizando banco mysql8:

create database `builders_pay` CHARACTER SET utf8 COLLATE utf8_general_ci;

Após a criação do banco e configuração do .env precisamos realizar a instalação do projeto Laravel, no terminal abra o diretório onde o projeto está instalado, supondo que você já tenha realizado a instalação do composer e do php na sua máquina, execute o comando composer install para realizar a instalação do projeto:

![image](https://user-images.githubusercontent.com/43793955/223226997-e2efdd57-e2f6-4925-91ee-5b39e485d0a5.png)

Após a instalação do projeto ser realizado por completa utilizando o composer, execute no terminal o comando php artisan migrate para configurar o banco de dados:

![image](https://user-images.githubusercontent.com/43793955/223227535-83cc2d84-6d03-4286-8422-9b42ce3bebca.png)

No seu banco de dados essas tabelas deverão ser criadas:

![image](https://user-images.githubusercontent.com/43793955/223227704-2aa3259d-08ba-402e-aef4-8c256682011b.png)

Sua aplicação está pronta para ser usada.

Para rodar a aplicação sem precisar da criação de um virtual host podemos utilizar o comando php artisan serve do Laravel (Comando que libera um host na porta 8000 do endereço local para utilização do Laravel):

![image](https://user-images.githubusercontent.com/43793955/223228954-e8051109-9941-4407-8a46-a2fa970c49b0.png)


# Utilizando as collections

Para facilitar o uso e o teste da API foi disponibilizado no diretório raiz do projeto uma collection do Postman para ser usada, junto também com o arquivo de environments da API.

- builders-pay.postman_collection.json
- ApiBuildersPayEnvironment.postman_environment.json

Ao importar a collection e o environment da API no Postman a chamada que iremos utilizar para os testes está no arquivo PaymentCalc, nesse arquivo temos o body enviando o "bar_code" e o "payment_date" para a API realizar o novo cálculo atualizado do valor do boleto:

![image](https://user-images.githubusercontent.com/43793955/223228433-7f76b1c7-2a02-496e-a092-a35ab9679d80.png)

Obs.: Para utilizar a API da BuildersPay é necessário enviar o API_TOKEN nas requisições, token que já está sendo passado dentro do arquivo de environments. Caso tenha criado um virtual host para rodar a aplicação e não esteja utilizando o php artisan serve do laravel, mude no arquivo de environments o valor de API_URL.

Ao enviar a requisição com os dados corretamente a resposta que esperamos é a seguinte (Com os dados de juros, multa e valor final do boleto atualizados):

{
    "original_amount": 260,
    "amount": 2083.73,
    "due_date": "2022-09-03",
    "payment_date": "2080-03-06",
    "interest_amount_calculated": 1818.53,
    "fine_amount_calculated": 5.2
}


# Testes

Para os testes foi utilizado o PHPUnit juntamente com o PestPHP, para executar nossa fila de testes pelo Laravel podemos executar o comando php artisan test

![image](https://user-images.githubusercontent.com/43793955/223229620-18543c9d-e16e-4559-a080-12f0f71646aa.png)

Documentação PestPHP: https://pestphp.com/

Nesse projeto não foi implementado uma uma pipeline para execução dos testes, mas entendo que poderia ser utilizado como de exemplo o GitHub Actions para criação de pipeline, tais como a criação de eventos para push, executando os testes antes de uma possível subida ou merge de uma feature na branch principal do projeto.


# Possíveis melhorias ao projeto

Apesar de ser apenas um projeto base, vejo possíveis melhorias, tal como o salvamento do token de acesso da api de consulta de boletos builders, atualmente a cada requisição estamos autenticando na API novamente, uma possível melhoria seria salvar esse token junto com a data de expiração para não realizar a autenticação a cada chamada. Também vejo como uma possível melhoria uma massa maior de testes, com uma cobertura mais ampla e mais tratamentos.



