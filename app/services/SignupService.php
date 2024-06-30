<?php
namespace Services;

use Repositories\SignupRepository;
use Models\User;

class SignupService
{
  private $signupRepository;

  function __construct()
  {
    $this->signupRepository = new SignupRepository();
  }

  public function createUser(User $user)
  {    //create a new user    
    return $this->signupRepository->createUser($user);
  }

}
