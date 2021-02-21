<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker=Factory::create();
        for($i=1;$i<5;$i++){
            $category =new Category();
            $category->setTitle("cat $i");
            $category->setDescription("description cat $i");
            $manager->persist($category);
            for($j=1;$j<=2;$j++){
                $article =new Article();
                $article->setTitle("Title $j");
                $article->setContent("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                ");
                $article->setCreatedAt($faker->dateTimeBetween('-6 months'));
                $article->setImage("https://picsum.photos/seed/picsum/300/150");
                $article->setCategory($category);
                $manager->persist($article);
                $today=new DateTime();
                $difference=$today->diff($article->getCreatedAt());
                $days=$difference->days;
                $comment_maximum='-'.$days.'days';
                for($k=0;$k<=mt_rand(4,6);$k++){
                    $comment=new Comment();
                    $comment->setAuthor($faker->name());
                    $comment->setContent($faker->text());
                    $comment->setCreatedAt($faker->dateTimeBetween($comment_maximum));
                    $comment->setArticle($article);
                    $manager->persist($comment);
                }
    
    
            }

        }
        
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
