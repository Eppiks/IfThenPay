# IfThenPay pagamentos por multibanco para Laravel 5
> Gerar facilmente referências multibanco no Laravel 5

## Service provider
[IfThenPay](https://www.ifthensoftware.com)

## Installation

[IfThenPay](https://www.ifthensoftware.com), [Laravel 5.1.*](http://laravel.com) and [Composer](https://getcomposer.org) are required.

Para ter a última versão do Eppiks IfThenPay, basta adicionar esta linha ao ficheiro `composer.json`.

```
"eppiks/ifthenpay"
```

or use the following command

```
$ composer require eppiks/ifthenpay
```

Depois basta correr o comando `composer update`.

De seguida, abrir o ficheiro `config/app.php` e adicionar a seguinte linhas ao array `providers`:

* `Eppiks\IfThenPay\IfThenPayServiceProvider::class,`

## Configuração

Para começar tem que adicionar os ficheiros ao seu projeto. Para isso corra o comando:

```bash
$ php artisan vendor:publish
```

Isto vai criar um ficheiro `config/IfThenPay.php` na sua pasta `config` para poder configurar os dados do IfThenPay.

De seguida, corra o comando `php artisan migrate`, isto vai criar uma tabela na base de dados para guardar os pagamentos feitos pelo multibanco.