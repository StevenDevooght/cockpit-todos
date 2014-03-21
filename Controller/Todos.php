<?php

namespace Todos\Controller;

class Todos extends \Cockpit\Controller {

    public function index() {
        return $this->render("todos:views/index.php");
    }
    
}

