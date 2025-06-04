<?php
use App\Database\Mariadb;
use App\Models\Tarefa;
use App\Models\Usuario;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
 
require __DIR__ . '/vendor/autoload.php';
 
$app = AppFactory::create();
$banco = new Mariadb();
 
$app->get('/usuario/{id}/tarefas',
 function (Request $request, Response $response, array $args) use ($banco)
  {
    $user_id = (int)$args['id'];
    $tarefa = new Tarefa($banco->getConnection());
    $tarefas = $tarefa->getAllByUser($user_id);
    $response->getBody()->write(json_encode($tarefas));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/usuario', function(Request $request, Response $response, array $args) use ($banco)
{
    $campos_obrigatório = ['nome', 'login', 'senha', 'email'];
    $body = $request->getParsedBody();
$usuario = new Usuario($banco->getConnection());
    try{
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
    }catch(\Exception $exception){
        $response->getBody()->write(json_encode(['message' => $exception->getMessage()
        ]));
        return $response->withheader('Content-Type', 'application/json')->withStatus(400);
    }
    $response->getBody()->write(json_encode([
        'message' => 'Usuário cadastrado com sucesso!'
    ]));
    return $response->withHeader('Content-Type', 'application/json');
});
 
 
$app->run();