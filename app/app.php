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

//register error handler
/*$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    switch ($code) {
        case 403:
            $message = 'Accès refusé';
            break;
        case 404:
            $message = 'La ressource demandé n\'a pas été trouvé';
            break;
        case 500:
            $message = " Url Inconnue";
            break;
        default:
            $message = "On dirait qu'il y une erreur.";
    }
    return $app['twig']->render('error.html.twig', array('message' => $message));
});*/
