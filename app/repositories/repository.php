<?php
namespace Repositories;

use PDO;
use PDOException;
use Models\User;
use Models\Roles;

class Repository {

    protected $connection;

    function __construct() {

        require __DIR__ . '/../dbconfig.php';

        try {
            $this->connection = new PDO("$type:host=$servername;dbname=$database", $username, $password);
                
            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
          }
    }
    public function fromRow(array $row)
  {
    $user = new User(
      $row['userName'],
      $row['password'],
      $row['age'],
      $row['gender'],
      $row['weight'],
      $row['height'],
      $row['goal'],
    );
    $user->setUserId($row['id']);
    $user->setRole(Roles::fromString($row['role'])); // Convert string to Roles instance

    return $user;
  }       
}