# Teste API Laravel (PHP)

## Requerimentos
- xampp 7.4
- composer
- npm
- node.js
- Postman

## Instalação

- instalar o Xampp 7.4 para windows (https://www.apachefriends.org/download.html)
- Clonar esse repositório em C:\xampp74\htdocs
- Criar um novo banco de dados no MySql : laravel_test (utf8mb4_unicode_ci)
- Duplicar o arquivo ".env.example" para ".env"
- Editar o arquivo .env e adicionar o nome do banco de dados na linha: DB_DATABASE=laravel e substituir por: DB_DATABASE=laravel_test
- Executar os seguintes comandos a seguir na linha de comando do windows
````
cd C:\xampp74\htdocs
git clone https://github.com/domwal/laravel-test.git
cd laravel-test\laravel-8
composer install
php artisan key:generate
php artisan migrate:fresh --seed
npm install && npm run dev
php artisan serve
````

- Agora abrir o navegador nesse endereço: [http://127.0.0.1:8000/eletrodomesticos](http://127.0.0.1:8000/eletrodomesticos)


Usuário login gerado (Essa API não requer usuário logado):
````
Usuário: admin@admin.com
Senha: password
````

<br>

## API 

- pode testar com o POSTMAN

### **Listagem dos eletrodomésticos**

> **Method**: <u>GET|HEAD</u>
> - ````
>   http://127.0.0.1:8000/api/listar-eletro-domestico
>   ````

<br>

### **Acessar um eletrodoméstico**

> **Method**: <u>GET|HEAD</u>
> - ````
>   http://127.0.0.1:8000/api/eletro-domestico/{id}
>   ````

<br>

### **Criar um Eletrodoméstico**

> **Method**: <u>POST</u>
> - ````
>   http://127.0.0.1:8000/api/eletro-domestico/{id}
>   ````

### **Editar um Eletrodoméstico**

- Edita um eletrodoméstico com base em seu ID.

> **Method**: <u>PUT|PATCH</u>
> - ````
>   http://127.0.0.1:8000/api/eletro-domestico/{id}
>   ````

<br>

| KEY | VALUE |
|-----|-------|
| maraca_id | ID da Marca |
| tensao | 110v ou 220v |
| nome | Nome do Eletrodoméstico |
| descricao | Descrição do eletrodoméstico |
| cor | Cor (string, insira o nome da Cor) |
| preco | preço (campo string, pode preecher ponto e virgula) |


<br>

### **Remover um Eletrodoméstico**

> **Method**: <u>DELETE</u>
> - ````
>   http://127.0.0.1:8000/api/eletro-domestico/{id}
>   ````

<br>


