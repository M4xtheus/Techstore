# ⚡ TechStore - E-commerce de Eletrônicos

Projeto final do 4º Bimestre para a disciplina de Desenvolvimento Web. 
Consiste em uma aplicação web completa de comércio eletrônico (E-commerce) com tema de eletrônicos, abrangendo o fluxo de venda ponta a ponta, desde a vitrine até o checkout com baixa de estoque.

## 🚀 Tecnologias Utilizadas

*   **Frontend:** HTML5, CSS3, Bootstrap 5, JavaScript (Vanilla).
*   **Backend:** PHP 8.x (Puro, sem frameworks).
*   **Banco de Dados:** MySQL / MariaDB.
*   **Conexão com Banco:** PDO (PHP Data Objects).
*   **Versionamento:** Git e GitHub.

## ⚙️ Funcionalidades Implementadas

### 🛍️ Área do Cliente (Loja)
*   **Vitrine Dinâmica:** Listagem de produtos com imagens, preços e indicador de estoque.
*   **Filtros e Busca:** Filtro por categorias e busca inteligente por nome/descrição.
*   **Página de Detalhes:** Visualização completa do produto, cálculo de parcelamento (12x) e verificação de estoque.
*   **Carrinho de Compras:** Adição, remoção e alteração de quantidade (com atualização de valores em tempo real via AJAX/Fetch e validação de estoque).
*   **Autenticação:** Cadastro de clientes e login seguro com criptografia de senhas.
*   **Checkout e Pagamento:** Finalização de compra com escolha de método de pagamento simulado (PIX com QR Code, Boleto com código de barras, e Cartão de Crédito com máscaras e parcelamento).
*   **Baixa de Estoque:** Controle automático de inventário no banco de dados após a compra.

### 🛡️ Área Administrativa (Painel Admin)
*   **Acesso Restrito:** Rota /admin bloqueada para usuários comuns (validação de sessão no servidor).
*   **CRUD de Produtos:** Criação, leitura, edição e exclusão de produtos.
*   **Upload de Imagens:** Sistema de upload de imagens personalizadas para os produtos.

## 🔒 Segurança Aplicada
*   Uso de **Prepared Statements** (PDO) em todas as consultas SQL para prevenção de SQL Injection.
*   **Criptografia de Senhas** utilizando password_hash() e password_verify().
*   Controle de sessão para rotas restritas (Painel Administrativo).
*   Validação de dados no back-end.

## 🛠️ Pré-requisitos para Rodar o Projeto

Antes de começar, você vai precisar ter instalado em sua máquina:
*   [XAMPP](https://www.apachefriends.org/pt_br/index.html) (ou servidor Apache + MySQL de sua preferência).
*   [Git](https://git-scm.com/) (opcional, para clonar o repositório).
*   Navegador Web atualizado.

## ⚙️ Como Instalar e Rodar

1. **Clone o repositório (ou baixe o ZIP):**
   git clone https://github.com/seu-usuario/techstore.git

2. **Configure o Banco de Dados:**
   *   Abra o painel do XAMPP e inicie os módulos **Apache** e **MySQL**.
   *   Acesse http://localhost/phpmyadmin/.
   *   Importe o arquivo database/schema.sql (que está na raiz do projeto) para criar as tabelas e os dados de teste.

3. **Configure as Variáveis de Ambiente:**
   *   Localize o arquivo .env.example e renomeie para .env.
   *   Abra o .env e preencha com as credenciais do seu banco local (geralmente usuário root e senha vazia):
       DB_HOST=localhost
       DB_PORT=3306
       DB_NAME=techstore
       DB_USER=root
       DB_PASS=

4. **Inicie o Servidor (Escolha uma das duas formas de acesso):**

   **Forma 1: Usando o VS Code e o Terminal (Recomendado para Desenvolvimento)**
   *   Certifique-se de que o **MySQL** do XAMPP está ligado (necessário para o banco).
   *   Abra o terminal do VS Code na pasta raiz do projeto.
   *   Execute o comando abaixo (usando o PHP do XAMPP):
       C:\xampp\php\php.exe -S localhost:8000 -t public
   *   Acesse no navegador: **http://localhost:8000**

   **Forma 2: Usando a pasta do XAMPP (Apache)**
   *   Movimente a pasta inteira do projeto para dentro do htdocs do XAMPP (o caminho deve ficar C:\xampp\htdocs\techstore).
   *   Ligue o **Apache** e o **MySQL** no painel do XAMPP.
   *   Acesse no navegador: **http://localhost/techstore/public/** 
   (Ou http://localhost/techstore/ se o arquivo redirecionador estiver na raiz).

## 👤 Contas de Teste (Criadas pelo schema.sql)

Para testar o sistema, utilize as seguintes credenciais:

*   **Administrador (Acesso ao Painel Admin):**
    *   E-mail: admin@techstore.com
    *   Senha: 123456
*   **Cliente:**
    *   E-mail: cliente@teste.com
    *   Senha: 123456

## 📁 Estrutura do Projeto

techstore/
├── database/      # Script SQL (schema.sql)
├── public/        # Raiz do servidor (index.php, assets, uploads)
├── src/           # Lógica do sistema (controllers, models, views, helpers)
├── .env.example   # Exemplo de variáveis de ambiente
├── .gitignore     # Arquivos ignorados pelo Git
└── README.md      # Documentação

## ✒️ Autor

*   **Matheus Caldeira** - Desenvolvimento Fullstack

---
Desenvolvido como parte da avaliação final do 4º Bimestre.