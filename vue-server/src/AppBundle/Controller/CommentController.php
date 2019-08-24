<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Comment;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
    /**
     * @Route("/add-comment", name="addComment")
     */
    public function addCommentAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $id = $data['id'];
        $content = $data['content'];
        $author = $data['author'];
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'X-Requested-With,content-type');
        if($id && $content) {
            $article=$this->getDoctrine()->getRepository(Article::class)->find($id);
            $author=$this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $author]);
            $comment=new Comment();
            $comment->setContent($content);
            $comment->setAuthor($author);
            $comment->setArticle($article);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            $response->setContent(json_encode([
                'id' => $comment->getId()
            ]));
            return $response;
        } else {
            $response->setContent(json_encode([
                'error' => 'error'
            ]));
            return $response;
        }

    }

    /**
     * @Route("/get-article-comments", name="getArticleComments")
     */
    public function getArticleCommentsAction(Request $request) {
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'X-Requested-With,content-type');

        $data = json_decode($request->getContent(), true);
        $id = $data['id'];
        if($id) {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery(
                'SELECT c, u.username
        FROM AppBundle:Comment c JOIN AppBundle:User u WITH u.id=c.author WHERE c.article=' . $id
            );
            $comments = $query->getArrayResult();
            $response->setContent(json_encode([
                $comments
            ]));
            return $response;
        } else {
            $response->setContent(json_encode([
                'error' => 'error'
            ]));
            return $response;
        }

    }
}
