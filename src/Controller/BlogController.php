<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog")
     */
    public function index(ArticleRepository $articleRepository): Response
    {   
        $articles =$articleRepository->findAll();
        //dump($articles);
        //die();
        return $this->render('blog/index.html.twig', [
            'articles'=> $articles
        ]);
    }
    /**
     * @Route("article/10",name="article_show")
     */
    public function show(){
        return $this->render('blog/show.html.twig');
    }
}
