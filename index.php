<?php

use App\Database\Mariadb;
use App\Models\Tarefa;
use App\Models\usuario;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$banco = new Mariadb();

// crud usuario

$app->get('/usuario/{id}/tarefa', 
    function(Request $request, Response $response, array $args) use ($banco)
 {
    $user_id = $args['id'];
    $tarefa = new Tarefa($banco->getConnection());
    $tarefas = $tarefa->getAllByUser($user_id);
    $response->getBody()->write(json_encode($tarefas));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/usuario', function (Request $request, Response $response, array $args) use ($banco) {
    $campos_obrigatório = ['nome', 'login', 'senha', 'email'];
    $body = $request->getParsedBody();
    $usuario = new Usuario($banco->getConnection());
    try {
        $usuario->nome = $body['nome'] ?? '';
        $usuario->login = $body['login'] ?? '';
        $usuario->senha = $body['senha'] ?? '';
        $usuario->email = $body['email'] ?? '';
        $usuario->foto_path = $body['foto_path'] ?? '';
        foreach ($campos_obrigatório as $campo) {
            if (empty($usuario->{$campo})) {
                throw  new \Exception("O campo {$campo} é obrigatório.");
            }
        }
        $usuario->create();
    } catch (\Exception $exception) {
        $response->getBody()->write(json_encode([
            'message' => $exception->getMessage()
        ]));
        return $response->withheader('Content-Type', 'application/json')->withStatus(400);
    }
    $response->getBody()->write(json_encode([
        'message' => 'Usuário cadastrado com sucesso!'
    ]));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->put(
    '/usuario/{id}',
    function (Request $request, Response $response, array $args) use ($banco) {
        $campos_obrigatório = ['nome', 'login', 'senha', 'email'];
        $body = $request->getParsedBody();

        try {
            $usuario = new Usuario($banco->getConnection());
            $usuario->id = $args['id'] ?? '';
            $usuario->nome = $body['nome'] ?? '';
            $usuario->email = $body['email'] ?? '';
            $usuario->login = $body['login'] ?? '';
            $usuario->senha = $body['senha'] ?? '';
            $usuario->foto_path = $body['foto_path'] ?? '';
            foreach ($campos_obrigatório as $campo) {
                if (empty($usuario->{$campo})) {
                    throw  new \Exception("O campo {$campo} é obrigatório.");
                }
            }
            $usuario->update();
        } catch (\Exception $exception) {
            $response->getBody()->write(json_encode([
                'message' => $exception->getMessage()
            ]));
            return $response->withheader('Content-Type', 'application/json')->withStatus(400);
        }
        $response->getBody()->write(json_encode([
            'message' => 'Usuário atualizado com sucesso!'
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    });

$app->delete('/usuario/{id}', 
    function(Request $request, Response $response, array $args) use ($banco)
 {
    $id = $args['id'];
    $usuario = new Usuario($banco->getConnection());
    $usuario->delete($id);
    $response->getBody()->write(json_encode(['message' => 'Usuário excluído']));
    return $response->withHeader('Content-Type', 'application/json');
});


//crud tarefa
$app->get('/tarefas/{id}', 
    function(Request $request, Response $response, array $args) use ($banco)
 {
    $id = $args['id'];
    $tarefa = new Tarefa($banco->getConnection());
    $tarefas = $tarefa->getarefaById($id);
    $response->getBody()->write(json_encode($tarefas));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post(
    '/tarefa',
    function (Request $request, Response $response, array $args) use ($banco) {
        $campos_obrigatório = ['titulo', 'status', 'user_id'];
        $body = $request->getParsedBody();
        $tarefa = new tarefa($banco->getConnection());
        try {
            $tarefa->titulo = $body['titulo'] ?? '';
            $tarefa->descricao = $body['descricao'] ?? '';
            $tarefa->status = $body['status'] ?? '';
            $tarefa->user_id = $body['user_id'] ?? '';
            foreach ($campos_obrigatório as $campo) {
                if (empty($tarefa->{$campo})) {
                    throw  new \Exception("O campo {$campo} é obrigatório.");
                }
            }
                 $tarefa->create();
        } catch (\Exception $exception) {
            $response->getBody()->write(json_encode([
                'message' => $exception->getMessage()
            ]));
            return $response->withheader('Content-Type', 'application/json')->withStatus(400);
        }
        $response->getBody()->write(json_encode([
            'message' => 'tarefa cadastrada com sucesso!'
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    }
);

$app->put(
    '/tarefa/{id}',
    function (Request $request, Response $response, array $args) use ($banco) {
        $campos_obrigatório = ['titulo', 'status', 'user_ID'];
        $body = $request->getParsedBody();

        try {
            $tarefa = new tarefa($banco->getConnection());
            $tarefa->id = $args['id'] ?? 0;
            $tarefa->titulo = $body['titulo'] ?? '';
            $tarefa->descricao = $body['descricao'] ?? '';
            $tarefa->status = $body['status'] ?? 0;
            $tarefa->user_id = $body['user_id'] ?? 0;
            foreach ($campos_obrigatório as $campo) {
                if (empty($tarefa->{$campo})) {
                    throw  new \Exception("O campo {$campo} é obrigatório.");
                }
            }
            $tarefa->update();
        } catch (\Exception $exception) {
            $response->getBody()->write(json_encode([
                'message' => $exception->getMessage()
            ]));
            return $response->withheader('Content-Type', 'application/json')->withStatus(400);
        }
        $response->getBody()->write(json_encode([
            'message' => 'tarefa atualizado com sucesso!'
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    });
    $app->delete('/tarefa/{id}', 
    function(Request $request, Response $response, array $args) use ($banco)
 {
    $id = $args['id'];
    $tarefa = new tarefa($banco->getConnection());
    $tarefa->delete($id);
    $response->getBody()->write(json_encode(['message' => 'Usuário excluído']));
    return $response->withHeader('Content-Type', 'application/json');
});



$app->run();
