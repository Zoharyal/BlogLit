<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;

ErrorHandler::register();
ExceptionHandler::register();

$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array( 'twig.path' => __DIR__.'/../views',));

$app['twig'] = $app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
});
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\AssetServiceProvider(), array('assets.version' => 'v1'));
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => function () use ($app) {
                return new BlogLit\DAO\UserDAO($app['db']);
            },
        ),
    ),
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_USER'),
    ),
    'security.access_rules' => array(
        array('^/admin', 'ROLE_ADMIN'),
    ),
));

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/logs/bloglit.log',
    'monolog.name' => 'BlogLit',
    'monolog.level' => $app['monolog.level']
));

// Register error handler

// Admin home page
$app->get('/admin', function() use ($app) {
    $chapters = $app['dao.chapter']->findAll();
    $comments = $app['dao.comment']->findAll();
    $users = $app['dao.user']->findAll();
    return $app['twig']->render('admin.html.twig', array(
        'chapters' => $chapters,
        'comments' => $comments,
        'users' => $users));
})->bind('admin');

//register services

$app['dao.chapter'] = function ($app) {
    return new BlogLit\DAO\ChapterDAO($app['db']);
};
$app['dao.user'] = function ($app) {
    return new BlogLit\DAO\UserDAO($app['db']);
};
$app['dao.comment'] = function ($app) {
    $commentDAO = new BlogLit\DAO\CommentDAO($app['db']);
    $commentDAO->setChapterDAO($app['dao.chapter']);
    return $commentDAO;
};