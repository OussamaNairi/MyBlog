<?php

namespace App\Controller;

use DateTime;
use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

class BlogController extends AbstractController
{

    private $security;
    public function __construct(Security $security){
     $this->security=$security;
    }
    


    /**
     * @Route("/", name="blog")
     */
    public function index(ArticleRepository $articleRepository,PaginatorInterface $paginator,Request $request): Response
    {   

        $articles =$paginator->paginate($articleRepository->findAll(),
        $request->query->getInt('page',1),
        2
        );
        //dump($articles);
        //die();
        return $this->render('blog/index.html.twig', [
            'articles'=> $articles
        ]);
    }
    /**
     * @Route("article/new" ,name="article_new")
     */
    public function new(Request $request,FlashyNotifier  $flashyNotifier){
        $article = new Article();
        $form = $this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $article->setCreatedAt(new DateTime());
            $article->setImage("https://picsum.photos/seed/picsum/300/150");
            $article->setUser($this->getUser());
            $entityManager =$this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            $flashyNotifier->success('Article Added!');
            return $this->redirectToRoute("article_show",['id'=>$article->getId()]);
        }
        return $this->render('blog/new.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("article/{id}/edit",name="article_edit")
     */
    public function edit(Request $request,Article $article,FlashyNotifier  $flashyNotifier): Response
    {
        $form=$this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
           
            $entityManager =$this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            $flashyNotifier->success('Article Edited!');
            return $this->redirectToRoute("article_show",['id'=>$article->getId()]);
        }

        return $this->render("blog/edit.html.twig",[
            'editForm'=>$form->createView()
        ]);
    }

    /**
     * @Route("article/{id}",name="article_show",methods={"GET","POST"})
     */
    public function show(Article $article,Request $request,FlashyNotifier  $flashyNotifier){
        $comment =new Comment();
        $form=$this->createForm(CommentType::class,$comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comment->setCreatedAt(new DateTime());
            $comment->setArticle($article);
            $entityManager =$this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
            $flashyNotifier->success('Comment Added!');
            return $this->redirectToRoute("article_show",['id'=>$article->getId()]);
        }

        return $this->render('blog/show.html.twig',[
            'article'=>$article,
            'commentForm'=>$form->createView()
        ]
    
    );
    }
    
}
