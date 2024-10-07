<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AuthorRepository;

class AuthorController extends AbstractController
{
    private $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }


    /*
    private $authors;
    public function __construct ()
    {
        
        $this->authors = [
            ['id' => 1, 'picture' => 'assets/image/vh.png', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com', 'nb_books' => 100],
            ['id' => 2, 'picture' => '/assets/ws.png', 'username' => 'William Shakespeare', 'email' => 'william.shakespeare@gmail.com', 'nb_books' => 200],
            ['id' => 3, 'picture' => '/assets/th.png', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300],
        ];
    }*/

    #[Route('/author', name: 'app_author',methods:['GET'])]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/showauthor/{name}', name: 'showAuthor',defaults:['name'=>'vector'],methods:['GET'])]
    public function showAuthor($name): Response
    {
        return $this->render('author/show.html.twig', [
            'name'=>$name,
        ]);
    }


    #[Route('/listAuthor', name: 'listAuthor', methods: ['GET'])]
    public function listAuthor(): Response
    {
        $authors = $this->authorRepository->listAuthors();
        return $this->render('author/list.html.twig', [
            'authors' => $authors,
        ]);
    }


    #[Route('/authorDetails/{id}', name: 'authorDetails', methods: ['GET'])]
    public function authorDetails($id): Response
    {
    $author = $this->authorRepository->authorDetails($id);
    
    // Handle the case where the author is not found
    if (!$author) {
        throw $this->createNotFoundException('Author not found');
    }

    return $this->render('author/showAuthor.html.twig', [
        'author' => $author,
    ]);
    }


}
