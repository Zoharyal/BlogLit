<?php

// Home page
$app->get('/', "BlogLit\Controller\HomeController::indexAction")
->bind('home');

// Detailed info about an article
$app->match('/chapter/{id}', "BlogLit\Controller\HomeController::chapterAction")
->bind('chapter');

// Login form
$app->get('/login', "BlogLit\Controller\HomeController::loginAction")
->bind('login');

// Admin zone
$app->get('/admin', "BlogLit\Controller\AdminController::indexAction")
->bind('admin');

// Add a new chapter
$app->match('/admin/chapter/add', "BlogLit\Controller\AdminController::addChapterAction")
->bind('admin_chapter_add');

// Edit an existing chapter
$app->match('/admin/chapter/{id}/edit', "BlogLit\Controller\AdminController::editChapterAction")
->bind('admin_chapter_edit');

// Remove an chapter
$app->get('/admin/chapter/{id}/delete', "BlogLit\Controller\AdminController::deleteChapterAction")
->bind('admin_chapter_delete');

// Edit an existing comment
$app->match('/admin/comment/{id}/edit', "BlogLit\Controller\AdminController::editCommentAction")
->bind('admin_comment_edit');

// Remove a comment
$app->get('/admin/comment/{id}/delete', "BlogLit\Controller\AdminController::deleteCommentAction")
->bind('admin_comment_delete');

//credit page
$app->match('/credit', "BlogLit\Controller\HomeController::creditAction")
->bind('credit');
