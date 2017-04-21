<?php

namespace BlogLit\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use BlogLit\Domain\Chapter;
use BlogLit\Form\Type\ChapterType;
use BlogLit\Form\Type\CommentType;


class AdminController {

    /**
     * Admin home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
        $chapters = $app['dao.chapter']->findAll();
        $comments = $app['dao.comment']->findAll();
        return $app['twig']->render('admin.html.twig', array(
            'chapters' => $chapters,
            'comments' => $comments
            ));
    }

    /**
     * Add article controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addChapterAction(Request $request, Application $app) {
        $chapter = new Chapter();
        $chapterForm = $app['form.factory']->create(ChapterType::class, $chapter);
        $chapterForm->handleRequest($request);
        if ($chapterForm->isSubmitted() && $chapterForm->isValid()) {
            $app['dao.chapter']->save($chapter);
         
            $app['session']->getFlashBag()->add('success', 'Le chapitre a été ajouté avec succès.');
            return $app->redirect($app['url_generator']->generate('admin'));
        }
        return $app['twig']->render('chapter_form.html.twig', array(
            'title' => 'New Chapter',
            'chapterForm' => $chapterForm->createView()));
    }

    /**
     * Edit chapter controller.
     *
     * @param integer $id Article id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editChapterAction($id, Request $request, Application $app) {
        $chapter = $app['dao.chapter']->find($id);
        $chapterForm = $app['form.factory']->create(ChapterType::class, $chapter);
        $chapterForm->handleRequest($request);
        if ($chapterForm->isSubmitted() && $chapterForm->isValid()) {
            $app['dao.chapter']->save($chapter);
            $app['session']->getFlashBag()->add('success', 'Le chapitre a été modifié avec succès.');
        }
        return $app['twig']->render('chapter_form.html.twig', array(
            'title' => 'Edit chapter',
            'chapterForm' => $chapterForm->createView()));
    }

    /**
     * Delete chapter controller.
     *
     * @param integer $id Article id
     * @param Application $app Silex application
     */
    public function deleteChapterAction($id, Application $app) {
        // Delete all associated comments
        $app['dao.comment']->deleteAllByChapter($id);
        // Delete the article
        $app['dao.chapter']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Le chapitre a été supprimé avec succès.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

    /**
     * Edit comment controller.
     *
     * @param integer $id Comment id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editCommentAction($id, Request $request, Application $app) {
        $comment = $app['dao.comment']->find($id);
        $commentForm = $app['form.factory']->create(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $app['dao.comment']->save($comment);
            return $app->redirect($app['url_generator']->generate('admin'));
            $app['session']->getFlashBag()->add('success', 'Le commentaire a été modifié avec succès.');
        }
        return $app['twig']->render('comment_form.html.twig', array(
            'title' => 'Edit comment',
            'commentForm' => $commentForm->createView()));
    }

    /**
     * Delete comment controller.
     *
     * @param integer $id Comment id
     * @param Application $app Silex application
     */
    public function deleteCommentAction($id, Application $app) {
        $app['dao.comment']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Le commentaire a été supprimé avec succès.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

    /**
     * Add user controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addUserAction(Request $request, Application $app) {
        $user = new User();
        $userForm = $app['form.factory']->create(UserType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // generate a random salt value
            $salt = substr(md5(time()), 0, 23);
            $user->setSalt($salt);
            $plainPassword = $user->getPassword();
            // find the default encoder
            $encoder = $app['security.encoder.bcrypt'];
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password); 
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'The user was successfully created.');
        }
        return $app['twig']->render('user_form.html.twig', array(
            'title' => 'New user',
            'userForm' => $userForm->createView()));
    }
}
