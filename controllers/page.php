<?php

/**
 * Simple pagescontroller
 */

namespace Controllers;

import('core.types');
import('core.controller');
import('core.template');
import('core.utils.mobile');
import('core.exceptions');
import('core.session.handler');
import('core.backend');
import('core.storage');
import('core.auth');
import('plugins.articles.article');

class Page extends \Core\Controller {
    protected $_backend;
    protected $_session;
    protected $_template;
    protected $_user;
    protected $_async;
    protected $_auth;

    public function __construct($args=False) {
        parent::__construct($args);
        $this->_init_session();
        $this->_init_template();
        $this->_init_auth();
        try {
            $this->_template->logged_in = True;
        } catch(\Core\AuthNotLoggedInError $e){
            $this->_template->logged_in = False;
        }
    }

    protected function _init_auth() {
        $this->_auth = \Core\Auth::container()
            ->get_auth('user', $this->_session);
    }

    protected function _init_template() {
        $t = \Core\Template::create();
        $t->_jsapps = array();
        $this->_template = $t;
    }


    protected function _init_session() {
        $this->_session = \Core\Session\Handler::container()
            ->get_hs_session();
    }

    public function index() {
        $this->_init();
        $t = $this->_template;
        $t->articles = \Plugins\Articles\Article::mapper()
            ->attach_storage(\Core\Storage::container()
                ->get_storage('Article')
            )
            ->get_latest_articles();

        $t->content = $t->render('news.php');
        $t->title = 'News';
        echo $t->render('main.php');
    }
    protected function _init() {
        $t = new \Core\Template();
        $t->date = new \DateTime();
        $t->title = $this->_pages[$this->_args['page']];
        $t->page = $this->_args['page'];
        $t->menu_items = $this->_pages;
        $t->is_mobile = \Core\Utils\Mobile::detect();
        $this->_template = $t;
    }
    public function display_article() {
        $this->_init();
        $t = $this->_template;
        try {
            $t->article = \Plugins\Articles\Article::mapper()
                ->get_article($this->_args['article_id']);
            $t->article_id = $this->_args['article_id'];
            $t->content = $t->render('news_article.php');
            $t->title = $t->article->title;
            $t->canonical = $t->article->id . '/' . $t->article->seo_title . ".html";
            echo $t->render('main.php');            
        } catch (\Plugins\Articles\ArticleNotFoundError $e) {
            throw new \Core\HTTPError(404, "Article #{$this->_args[article_id]}");
        }
    }
}