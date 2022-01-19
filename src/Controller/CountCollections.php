<?php

namespace App\Controller;

use App\Repository\PostRepository;

class CountCollectionsController
{
    public function __construct(private PostRepository $postRepository)
    {        
    }

    public function __invoke(): int
    {
       return $this->postRepository->count([]);
    }
}