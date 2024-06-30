<?php

namespace Repositories;

use PDO;
use Models\User;

class LoginRepository extends Repository
{

  public function authenticate($username, $password)
  {
    try {
      $stmt = $this->connection->prepare("
            SELECT id, userName, password, age, gender, weight, height, bmrInfo, goal, caloriesIntake, role
            FROM users
            WHERE BINARY userName = :username
        ");
      $stmt->bindParam(':username', $username);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($row === false) {
        // No user found with the provided username
        return false;
      }
      $user = $this->fromRow($row);
      $result = $this->verifyPassword($password, $user->getPassword());
      if (!$result) {
        // The provided password doesn't match the user's password
        return false;
      }
      $user->setPassword("");
      return $user;

    } catch (\PDOException $e) {
      echo $e;
    }
  }
  

  // hash the password (currently uses bcrypt)
  function hashPassword($password)
  {
    return password_hash($password, PASSWORD_DEFAULT);
  }

  // verify the password hash
  function verifyPassword($input, $hash)
  {
    return password_verify($input, $hash);
  }

}