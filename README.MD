# WSL 
Permite rodar distribuições linux dentro do windows.

O comando abaixo instala o Ubuntu como distribuição wsl.
```bash
wsl --install -d Ubuntu 
```
No powershell, na primeira vez que executar o comando 'wsl', vai ser pedido para escolher um nome de usuário, digitar a senha e digitar a senha novamente.

> Obs: ao digitar a senha **nunca**, será mostrado os caracteres.

# Pós instalação 
Na pós instalação deve-se atualizar o sistema operacional com os comandos 

```bash 
sudo apt update 
sudo apt upgrade 
```

# Instalar o mariadb como banco de dados.

Antes de instalar qualquer programa, sempre validar se a lista de programas está atualizada

```bash
sudo apt update
```

Instalar o mariadb 
```bash
sudo apt install mariadb-server
```

# Pós instalação do mariadb 
Roda o comando:
```bash
sudo mysql_secure_installation
```

Enter current password for root (enter for none):  #enter 
Switch to unix_socket authentication [Y/n]      # n
Change the root password? [Y/n]  # y
New password:  # 123456
Remove anonymous users? [Y/n] # y
Disallow root login remotely? [Y/n] # n
Remove test database and access to it? [Y/n] # y
Reload privilege tables now? [Y/n] # y

# Como inciar e parar o serviço do banco de dados 
```bash
sudo systemctl start mariadb #inicia
sudo systemctl stop mariadb  #para
sudo systemctl restart mariadb #reinicia
sudo systemctl status mariadb #verifica o status 
```

# criação do banco de dados
acessar com:

```bash
mysql -uroot -p
```
### cria um banco
```sql
create database my_tarefas;
```

### cria colunas 
```sql
--- tabela usuario
create table usuario (
    id int not null primary key auto_increment, 
    nome varchar(100) not null,
    login varchar(50) not null unique,
    senha varchar(225) not null,
    email varchar(255) not null unique, 
    foto_path varchar(255) null
);
```

```sql
create table tarefas (
    id int not null primary key auto_increment, 
    itulo varchar(100) not null,
    descricao text not null,
    status tinyint(1) not null,
    user_id int not null,
    CONSTRAINT fk_usuario_tarefa FOREIGN KEY (user_id) REFERENCES usuario (id)
    ON DELETE CASCADE ON UPDATE CASCADE

);
```

# Verificar a estrutura da tabela
```sql
describe usuario;
describe tarefa;
```
## Verificar se tem algo na tabela
```sql
select * from usuario;
select * from tarefa;
```

# API - CRUD de Tarefas

## Desenvolvedor

**Nome completo:** Maria Luiza De Freitas

**Data da entrega:** 24/06/2025

---

## Descrição

Esta API foi desenvolvida como parte de uma atividade prática e tem como objetivo realizar o gerenciamento de tarefas por meio de um CRUD completo. As funcionalidades implementadas são:

- Criar uma nova tarefa (post)
- Listar todas as tarefas (get)
- Atualizar uma tarefa existente (put)
- Excluir uma tarefa (delete)
 
 ## Testes

### ✔️ Criar tarefa
! [imprimir nova tarefa](imgs/testemetodoposttarefa.png)

### ✔️ Listar tarefa
! [imprimir todas as tarefas](imgs/testemetodogettarefa.png)


### ✔️ Atualizar tarefa
! [Atualizar](imgs/putput.png)

 ### ✔️ Deletar tarefa
! [imprimir deletar](imgs/delete.png)
