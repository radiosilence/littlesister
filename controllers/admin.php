<?php

namespace Controllers;

import('core.types');
import('core.controller');
import('core.template');
import('core.utils.mobile');
import('core.exceptions');
import('core.validation');
import('controllers.page');
import('plugins.articles.article');

class Admin extends \Controllers\Page {
    protected $_confirmed_request;
    public function __construct($args=False) {
        parent::__construct($args);
        $t = $this->_template;
        try {
            $t->user_data = $this->_auth->user_data();
            $tok = ($_POST['_tok'] ? $_POST['_tok'] : $_GET['_tok']);
            $this->_confirmed_request = ($this->_session->get_tok() == $tok);
        } catch(\Core\AuthNotLoggedInError $e) {
            if($args['__uri__'] != '/admin/login') {
                header('Location: /admin/login');
                exit();
            }
        }
        $jsapps = $t->_jsapps;
        array_push($jsapps, '/js/admin.js');
        $t->_jsapps = $jsapps;

    }
    public function index() {
        $t = $this->_template;
        $at = \Plugins\Articles\Plugin::get_template('admin/list.php');
        $at->admin_url = '/admin';
        $at->articles = \Plugins\Articles\Article::mapper()
            ->attach_storage(\Core\Storage::container()
                ->get_storage('Article')
            )
            ->get_latest_articles(True);
        $t->admin_content = $at->render();
        $t->content = $t->render('admin_home.php');
        echo $t->render('main.php');
    }
    public function edit_article() {
        $t = $this->_template;
        $t->admin_content = $this->_edit_article(
            $this->_session->get_tok(),
            $this->_auth->user_id(),
            $this->_args['article_id']
        );
        $t->content = $t->render('admin_home.php');
        echo $t->render('main.php');
    }

    public function delete_article() {
        $t = $this->_template;
        $article = \Plugins\Articles\Article::container()
            ->get_by_id($this->_args['article_id']);

        $at = \Plugins\Articles\Plugin::get_template('admin/delete.php');
        $at->article = $article;
        $at->admin_url = "/admin";
        if($_POST['confirm'] == '1') {
            $at->_confirmed = True;
            \Core\Storage::container()
                ->get_storage('Article')
                ->delete($article);
        } else {
            $at->_confirmed = False;
        }

        $t->content = $at->render();
        echo $t->render('main.php');
    }

    public function set_article_active() {
        $t = $this->_template;
        $article = \Plugins\Articles\Article::container()
            ->get_by_id($_POST['article_id']);
        
        $article->active = $_POST['active'] == "true" ? 1 : 0;
        $msg = sprintf("Article %s set as %s.",
            $article['id'],
            ($article->active ? 'active' : 'inactive')
        );
        \Core\Storage::container()
            ->get_storage('Article')
            ->save($article);

        $t->set_file('message.php');
        $t->content = $this->_return_message("Success",
            $msg);
        echo $t->render('main.php');
    }

    protected function _edit_article($tok, $author, $id=False) {
        $t = \Plugins\Articles\Plugin::get_template('admin/edit.php');
        $t->admin_url = "/admin";
        $t->tok = $tok;
        try {
            if($id) {
                $t->title = "Edit Article";
                $article = \Plugins\Articles\Article::container()
                    ->get_by_id($id);
            } else {
                $t->title = "Create Article";
                $t->new = True;
                $article = \Plugins\Articles\Article::create($_POST, True);
            }

            if($_POST['_do'] == '1' && $this->_confirmed_request) {
                $article->overwrite($_POST);
                $article->form_values();
                $validator = \Core\Validator::validator('\Plugins\Articles\Article');
                $validator->validate($_POST, \Plugins\Articles\Article::validation());
                
                if($t->new) {
                    $article->author = $author;
                }

                \Core\Storage::container()
                    ->get_storage('Article')
                    ->save($article);
            }

            $t->article = $article;
                
        } catch(\Core\ValidationError $e) {
            return $this->_return_message("Fail",
                "Validation error(s):",
                $e->get_errors(), $t);
        }

        return $t->render();
    }

    public function login() {
        try {
            $this->_auth->user_id();
            header('Location: /admin');
        } catch(\Core\AuthNotLoggedInError $e) {
            $t = $this->_template;
            $t->user_field = "User";
            $t->login_action = '/admin/login';
            $t->set_file('login_page.php');
                
            if(isset($_POST['username'])) {
                try {
                    $this->_auth->attempt($_POST['username'], $_POST['password']); 
                    $t->content = $this->_return_message("Success",
                        "Logged in.");       
                    header('Location: /admin');
                } catch(\Core\AuthAttemptError $e) {
                    $t->content = $this->_return_message("Fail",
                        "Invalid username or password.");
                }            
            } else {
                $t->content = $t->render();
            }
            echo $t->render('main.php');
        }
    }

    public function logout() {
        $this->_auth->logout();
        header('Location: /admin/login');
    }


}