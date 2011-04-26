<?php // Routeses

$routes = array(
    '^([0-9]+)(.*)$' => 'Page:method=display_article;article_id=$1;__cache__=on',
    '^admin/login' => 'Admin:method=login',
    '^admin/logout' => 'Admin:method=logout',
    '^admin/set-article-active' => 'Admin:method=set_article_active',
    '^admin/edit-article/?(.*)$' => 'Admin:method=edit_article;article_id=$1',
    '^admin/delete-article/(.*)$' => 'Admin:method=delete_article;article_id=$1',
    '^admin/new-article$' => 'Admin:method=edit_article',
    '^admin' => 'Admin',
    '^$' => 'Page:method=index;__cache__=on'
);

