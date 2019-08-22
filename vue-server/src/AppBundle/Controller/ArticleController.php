<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{
    /**
     * @Route("/new-article", name="newArticle")
     */
    public function newArticleAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $title=$data['title'];
        $summary=$data['summary'];
        $content=$data['content'];
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'X-Requested-With,content-type');
        if($title && $summary && $content) {
            $article= new Article();
            $article->setTitle($title);
            $article->setSummary($summary);
            $article->setContent($content);
            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

                $response->setContent(json_encode([
                    'id' => $article->getId()
                ]));
                return $response;
        } else {
            $response->setContent(json_encode([
                'error' => 'error',
            ]));
            return $response;
        }
    }
}
