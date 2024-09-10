## Guia de Configuração do Projeto Laravel 


Este arquivo README fornece instruções sobre como clonar e configurar um projeto Laravel usando o Git.


## Pré-requisitos


Antes de clonar o projeto, certifique-se de que você tenha o seguinte instalado na sua máquina / Herd:
1. Herd: Garantir que o Herd está instalado na Máquina
2. Composer : Instale o composeer
3. PHP: Certifique-se de ter pelo menos PHP 8.x instalado no Herd.
4. Banco de Dados: Um banco de dados como MySQL, para tal deverá instalar o XAMPP que será usado para executar a BD. Para criar a BD utilize o procedimento normal do XAMPP, após criar essa BD mantenha somente o serviço de MySQL a rodar.


## Passos para Clonar o Projeto Laravel


Siga estes passos para configurar o projeto Laravel localmente.


### 1. Clonar o Repositório


Primeiro, clone o repositório do GitHub (ou de outro repositório) para sua máquina local ou baixe o repositótio:ULR: https://github.com/WiltonBaltazar/Willow-Library-App.git
Copie a pasta para o Herd localize a pasta Herd on irá instalar e coloque a pasta que irá baixar no Github


### 2. Navegar para o Diretório do Projeto


Após baixar, entre no diretório do projeto e abra pelo VS Code ou qualquer outro editor.


### 3. Instalar Dependências PHP
Usando a terminal, execute o seguinte comando para instalar as dependências necessárias usando o Composer:


```bash
composer install
```


### 4. Configurar o Arquivo de Ambiente


Copie o arquivo `.env.example` para criar o arquivo `.env`, que armazena as variáveis de ambiente:


```bash
cp .env.example .env
```


### 5. Gerar a Chave da Aplicação


Execute este comando para gerar uma nova chave de aplicação para o projeto Laravel:


```bash
php artisan key:generate
```


Isso atualizará o arquivo `.env` com uma chave única `APP_KEY`.


### 6. Configurar Variáveis de Ambiente


Atualize o arquivo `.env` para corresponder ao seu ambiente local. Você precisará modificar os seguintes campos:


DB_CONNECTION: mysql
DB_HOST:127.0.0.1
DB_PORT:3306
DB_DATABASE: willow.
DB_USERNAME: root
DB_PASSWORD: deixe a senha em branco



### 7. Executar as Migrações do Banco de Dados


Agora, execute as migrações do banco de dados para criar as tabelas:


```bash
php artisan migrate
```


### 8. Preencher o Banco de Dados 


Se o seu projeto tiver dados de exemplo, você pode preencher o banco de dados com os seeders:


```bash
php artisan db:seed
```
Este comando irá criar um utilizador com previlégio Admin com os dados 
email: admin@willow.edu.mz
senha: password 
isso vai permitir que acedam a plataforma
### 9. Rodar a Aplicação
Abra o herd e localize sites, clica sobre o link e a aplicação irá abrir no browser


## Notas Adicionais


- Se você enfrentar problemas de permissão, certifique-se de que os diretórios `storage` e `bootstrap/cache` estejam com permissões de escrita:


```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```


- Se você estiver usando um banco de dados diferente do MySQL, certifique-se de atualizar o arquivo `.env` adequadamente.


## Conclusão


Seu projeto Laravel agora deve estar funcionando. Para mais personalizações ou configurações, consulte a [documentação oficial do Laravel](https://laravel.com/docs).
