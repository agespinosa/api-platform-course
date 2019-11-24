<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       $blogPost= new BlogPost();
       $blogPost->setAuthor("Espinosa Nonica");
       $blogPost->setContent("Este es el contenido de monica");
       $blogPost->setPublished(new \DateTime("2019-10-20 12:00:00"));
       $blogPost->setSlug("blog-moni");
       $blogPost->setTitle("Religion y mascotas");

       $manager->persist($blogPost);

        $blogPost= new BlogPost();
        $blogPost->setAuthor("Recalde Rene");
        $blogPost->setContent("Este es el contenido de Rene");
        $blogPost->setPublished(new \DateTime("2019-10-10 12:00:00"));
        $blogPost->setSlug("blog-rene");
        $blogPost->setTitle("Motos y webgl");

        $manager->persist($blogPost);

        $manager->flush();
    }
}
