<?php

namespace BlogLit\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use BlogLit\Domain\Comment;
use BlogLit\Form\Type\CommentType;

class HomeController {

    /**
     * Home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
        $chapters = $app['dao.chapter']->findAll();
        return $app['twig']->render('index.html.twig', array('chapters' => $chapters));
    }
    
    /**
     * chapter details controller.
     *
     * @param integer $id chapter id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function chapterAction($id, Request $request, Application $app) {
        $chapter = $app['dao.chapter']->find($id);
        $chapters = $app['dao.chapter']->findAll();
        $commentFormView = null;
            // A user he can add comments
            $comment = new Comment();
            $comment->setChapter($chapter);
            $commentForm = $app['form.factory']->create(CommentType::class, $comment);
            $commentForm->handleRequest($request);
            if ($commentForm->isSubmitted() && $commentForm->isValid()) {
                $app['dao.comment']->save($comment);
                $app['session']->getFlashBag()->add('success', 'Votre commentaire a été ajouté avec succès.');
            }
            $commentFormView = $commentForm->createView();
        
        $comments = $app['dao.comment']->findAllByChapter($id);
        
        return $app['twig']->render('chapter.html.twig', array(
            'chapter' => $chapter,
            'chapters' => $chapters,
            'comments' => $comments,
            'commentForm' => $commentFormView));
    }
    
    /**
     * User login controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function loginAction(Request $request, Application $app) {
        return $app['twig']->render('login.html.twig', array(
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ));
    }
}
