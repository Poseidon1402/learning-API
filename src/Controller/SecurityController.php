<?php

namespace App\Controller;

use PHP_CodeSniffer\Reports\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route(path: '/api/login', name: 'api_login', methods: ['POST'])]
    public function index(): Json
    {
       $user = $this->getUser();
       return new Json([
           'username' => $user->getUsername(),
           'ROLES' => $user->getRoles()
       ]);
    }
}