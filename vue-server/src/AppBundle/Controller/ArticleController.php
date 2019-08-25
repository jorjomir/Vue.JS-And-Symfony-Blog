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
        $title = $data['title'];
        $summary = $data['summary'];
        $content = $data['content'];
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'X-Requested-With,content-type');
        if ($title && $summary && $content) {
            $article = new Article();
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

    /**
     * @Route("/article", name="viewArticle")
     */
    public function viewArticleAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $id = $data['id'];
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'X-Requested-With,content-type');
        if ($id) {
            /** @var Article $article */
            $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
            if ($article) {
                $response->setContent(json_encode([
                    'title' => $article->getTitle(),
                    'summary' => $article->getSummary(),
                    'content' => $article->getContent(),
                    'dateAdded' => $article->getDateAdded()
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

    /**
     * @Route("/all-articles", name="allArticles")
     */
    public function allArticlesAction(Request $request) {
        //$articles=$this->getDoctrine()->getRepository(Article::class)->findAll();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT a
        FROM AppBundle:Article a ORDER BY a.id DESC'
        );
        $articles = $query->getArrayResult();

        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'X-Requested-With,content-type');
        $response->setContent(json_encode([
            $articles
        ]));
        return $response;
    }

    /**
     * @Route("/edit-article", name="editArticle")
     */
    public function editArticleAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $id = $data['id'];
        $title = $data['title'];
        $summary = $data['summary'];
        $content = $data['content'];
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'X-Requested-With,content-type');
        if ($id) {
            $article=$this->getDoctrine()->getRepository(Article::class)->find($id);
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

    /**
     * @Route("/delete-article", name="deleteArticle")
     */
    public function deleteArticleAction(Request $request) {
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'X-Requested-With,content-type');

        $data = json_decode($request->getContent(), true);
        $id = $data['id'];
        if($id) {
            /** @var Article $article */
            $article=$this->getDoctrine()->getRepository(Article::class)->find($id);
            $comments=$article->getComments();
            foreach($comments as $comment) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($comment);
                $em->flush();
            }

            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();

            $response->setContent(json_encode([
                'success' => 'success'
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
