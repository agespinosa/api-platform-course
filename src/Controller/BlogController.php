<?php
namespace App\Controller;

use App\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;


/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    private const POSTS= [
        [
            'id'=> 1,
            'slug'=> "Hello-World",
            'title'=> "Hello World"
        ],
        [
            'id'=> 2,
            'slug'=> "Another-Post",
            'title'=> "Another Post"
        ],
        [
            'id'=> 3,
            'slug'=> "Last-Example",
            'title'=> "Last Example"
        ]
    ];

    /**
     * @Route("/{page}", name="blog_list" , defaults={"page":5} , requirements={"page"="\d+"})
     */
    public function list($page=1, Request $request){
        $limit= $request->get('limit');
        $master= $request->get('master');
        return new JsonResponse(
            [
                'page'=>$page,
                'limit'=>$limit,
                'master'=>$master,
                'data'=> array_map(function ($item){
                    return $this->generateUrl('blog_by_slug', ['slug'=> $item['slug']]);
                }, self::POSTS)
            ]
        );
    }
    /**
     * @Route("/post/{id}", name="blog_id" , requirements={"id"="\d+"}, methods={"GET"})
     */
    public function post($id){
        return new JsonResponse(
            self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
        );
    }
    /**
     * @Route("/post/{slug}", name="blog_by_slug")
     */
    public function postBySlug($slug){
        return new JsonResponse(
            self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]
        );
    }

    /**
     * @Route("/add", methods={"POST"}, name="blog_add")
     */
    public function add(Request $request){
        /** @var Serializer $serializer */
        $serializer= $this->get('serializer');
        $blogPost= $serializer->deserialize($request->getContent(), BlogPost::class, 'json');
        $em =$this->getDoctrine()->getManager();
        $em->persist($blogPost);
        $em->flush();

        return $this->json($blogPost);
    }

}