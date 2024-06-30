<?php
namespace Services;

use Repositories\LoginRepository;

class LoginService
{
  private $loginRepository;

  function __construct()
  {
    $this->loginRepository = new LoginRepository();
  }

  public function authenticate($username, $password)
  {
    return $this->loginRepository->authenticate($username, $password);
  }

}