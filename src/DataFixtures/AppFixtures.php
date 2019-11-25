<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use function Sodium\add;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadBlogPosts($manager);
    }

    public function loadBlogPosts(ObjectManager $manager){

        $user=$this->getReference('user_admin');
        $blogPost= new BlogPost();
        $blogPost->setContent("Este es el contenido de monica");
        $blogPost->setPublished(new \DateTime("2019-10-20 12:00:00"));
        $blogPost->setSlug("blog-moni");
        $blogPost->setTitle("Religion y mascotas");
        $blogPost->setAuthor($user);

        $manager->persist($blogPost);

        $blogPost= new BlogPost();
        $blogPost->setContent("Este es el contenido de Rene");
        $blogPost->setPublished(new \DateTime("2019-10-10 12:00:00"));
        $blogPost->setSlug("blog-rene");
        $blogPost->setTitle("Motos y webgl");
        $blogPost->setAuthor($user);

        $manager->persist($blogPost);

        $manager->flush();

    }
    public function loadComments(ObjectManager $manager){

    }
    public function loadUsers(ObjectManager $manager){

        $user= new User();
        $user->setUsername("admin");
        $user->setEmail('admin@blog.com');
        $user->setName('Administrador');

        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'secret123#'
        ));
        $this->addReference('user_admin', $user);
        $manager->persist($user);
        $manager->flush();
    }
}
