<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for($i=1;$i<5;$i++){
            $category =new Category();
            $category->setTitle("cat $i");
            $category->setDescription("description cat $i");
            $manager->persist($category);
            for($j=1;$j<=2;$j++){
                $article =new Article();
                $article->setTitle("Title $i");
                $article->setContent("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                ");
                $article->setCreatedAt(new \DateTime());
                $article->setImage("https://picsum.photos/seed/picsum/300/150");
                $article->setCategory($category);
                $manager->persist($article);
    
    
            }

        }
        
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
