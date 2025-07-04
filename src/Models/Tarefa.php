<?php 
namespace App\Models;

class Tarefa
{

private \PDO $connection;

  public ?int $id = null;
  public string $titulo = "";
  public string $descricao = "";
  public bool $status = false;
  public int $user_id = 0;
  
public function __construct(\PDO $connection)
{
  $this->connection = $connection;
}

public function create(): bool
{
    $sql = "INSERT INTO tarefas (titulo, descricao, status, user_id)
        VALUES (:titulo, :descricao, :status, :user_id)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
          ':titulo' => $this->titulo,
          ':descricao' => $this->descricao,
          ':status' => $this->status,
          ':user_id' => $this->user_id,
        ]);
}

public function getarefaById(int $id): ?array
{
    $sql = "SELECT * FROM tarefas WHERE id = :id";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute([':id' => $id]);

    $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);

    if($resultado){
      return $resultado;
    }
    return [];
}


public function update(): bool 
{
  $sql = "UPDATE tarefas SET titulo = :tiulo, descricao = :descricao,
    status = :status, user_id = :userid WHERE  id = :id";
    $stmt = $this->connection->prepare($sql);
    return $stmt->execute([
     ':id' => $this->id,
     ':titulo' => $this->titulo,
     ':descricao' => $this->descricao,
     ':status' => (int)$this->status,
     ':user_id' => $this->user_id,
    ]);
}

public function delete(int $id): bool
{
   $sql = "DELETE FROM tarefas WHERE id = :id";
   $stmt = $this->connection->prepare($sql);
   return $stmt->execute([':id' => $id]);
}

public function getAllByUser(int $user_id) : array
 {
  $sql = "SELECT * FROM tarefas where user_id = :user_id";
  $stmt =  $this->connection->prepare($sql);
  return $stmt->fetchAll();
 }

} 
?>