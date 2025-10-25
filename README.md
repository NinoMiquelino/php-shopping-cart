## 👨‍💻 Autor

<div align="center">
  <img src="https://avatars.githubusercontent.com/ninomiquelino" width="100" height="100" style="border-radius: 50%">
  <br>
  <strong>Onivaldo Miquelino</strong>
  <br>
  <a href="https://github.com/ninomiquelino">@ninomiquelino</a>
</div>

---

# 🛒 Sistema de Carrinho de Compras Persistente (PHP Sessions & AJAX)

![Made with PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)
![Frontend JavaScript](https://img.shields.io/badge/Frontend-JavaScript-F7DF1E?logo=javascript&logoColor=black)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-38B2AC?logo=tailwindcss&logoColor=white)
![License MIT](https://img.shields.io/badge/License-MIT-green)
![Status Stable](https://img.shields.io/badge/Status-Stable-success)
![Version 1.0.0](https://img.shields.io/badge/Version-1.0.0-blue)
![GitHub stars](https://img.shields.io/github/stars/NinoMiquelino/php-shopping-cart?style=social)
![GitHub forks](https://img.shields.io/github/forks/NinoMiquelino/php-shopping-cart?style=social)
![GitHub issues](https://img.shields.io/github/issues/NinoMiquelino/php-shopping-cart)

Este projeto é uma simulação funcional do núcleo de um e-commerce, focando na arquitetura de persistência de dados do lado do servidor (PHP Sessions) e na interação assíncrona do lado do cliente (AJAX/JavaScript).

---

## 🚀 Arquitetura e Destaques

* **Persistência de Sessão:** O coração do projeto é a classe `CartManager` em PHP, que utiliza a superglobal `$_SESSION` para armazenar o carrinho de compras. Isso garante que os itens permaneçam no carrinho mesmo que o usuário navegue entre `index.html` e `cart.html`.
* **PHP POO:** A classe `CartManager` encapsula toda a lógica de negócio (adicionar, remover, atualizar quantidade, calcular total), mantendo o código do endpoint `api.php` limpo e focado no roteamento.
* **Catálogo JSON:** O catálogo de produtos é lido de um arquivo `products.json`, simulando uma fonte de dados estática ou um banco de dados simples.
* **Comunicação AJAX (Full CRUD):** O frontend (JavaScript) utiliza requisições assíncronas (`fetch` com métodos GET, POST, PUT, DELETE) para interagir com o carrinho, garantindo uma experiência de usuário fluida, sem recarregamentos de página.
* **Roteamento por Método HTTP:** O endpoint `api.php` roteia as requisições baseando-se no método HTTP (`$_SERVER['REQUEST_METHOD']`), seguindo os princípios RESTful para o gerenciamento de recursos.

---

## 🛠️ Tecnologias Utilizadas

* **Backend:** PHP 7.4+ (POO, Sessions, Manipulação de JSON).
* **Frontend:** HTML5, JavaScript Vanilla (`fetch` API) e Tailwind CSS.

---

## 🧩 Estrutura do Projeto

```
php-shopping-cart/
├── index.html
├── cart.html
├── README.md
├── .gitignore
└── 📁 src/
         ├── products.json
         ├── CartManager.php
         └── api.php
```
---

## ⚙️ Configuração e Instalação

### Pré-requisitos

1.  Um ambiente de servidor web com PHP.

### Execução

1.  Crie a estrutura de pastas e preencha o `src/products.json`.
2.  Execute o servidor embutido do PHP (a partir da raiz do projeto):

    ```bash
    php -S localhost:8001
    ```

3.  Acesse a vitrine de produtos: `http://localhost:8001/public/index.html`.

---

## 📝 Instruções de Uso

1.  **Adicionar:** Clique no botão "Adicionar ao Carrinho" no `index.html`. A contagem de itens no header (`🛒 Carrinho (X)`) será atualizada via AJAX.
2.  **Ver Carrinho:** Clique no link do carrinho para ir para `cart.html`. Seus itens estarão persistidos pela sessão.
3.  **Atualizar Quantidade:** Na página `cart.html`, use o campo de input de quantidade. O evento `onchange` dispara uma requisição **PUT** para atualizar o valor. Se a quantidade for definida para 0, o item será removido.
4.  **Remover Item:** Clique no ícone de lixeira (❌) para disparar uma requisição **DELETE** para um item específico.
5.  **Limpar Carrinho:** Use o botão "Limpar Carrinho" para disparar um **DELETE** com o parâmetro `?action=clear`, limpando toda a sessão do carrinho.

---

## 🤝 Contribuições
Contribuições são sempre bem-vindas!  
Sinta-se à vontade para abrir uma [*issue*](https://github.com/NinoMiquelino/php-shopping-cart/issues) com sugestões ou enviar um [*pull request*](https://github.com/NinoMiquelino/php-shopping-cart/pulls) com melhorias.

---

## 💬 Contato
📧 [Entre em contato pelo LinkedIn](https://www.linkedin.com/in/onivaldomiquelino/)  
💻 Desenvolvido por **Onivaldo Miquelino**

---
