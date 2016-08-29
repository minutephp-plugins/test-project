<?php

/** @var Router $router */
use Minute\Model\Permission;
use Minute\Routing\Router;

$router->get('/test', 'Homepage', false, 'blogs[2]', 'posts[blogs.blog_id][2] as stories order by post_id', 'comments[stories.post_id][2]', 'users[comments.user_id] as commenter', 'users[2] as users')
    ->setDefault('blogs', '*')->setDefault('users', '*')
    ->setReadPermission('blogs', Permission::EVERYONE)->setReadPermission('users', Permission::EVERYONE);

$router->post('/test', null, false, 'Comment as comments')->setAllPermissions('comments', Permission::EVERYONE)
    ->setDeleteCascade('comments', 'Like');
$router->post('/test', null, false, 'Post as posts')->setDeletePermission('posts', Permission::EVERYONE);

$router->get('/members2', 'Members/Dashboard', true);
