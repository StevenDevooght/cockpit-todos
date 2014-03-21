<?php

namespace Todos\Controller;

class Api extends \Cockpit\Controller {

    public function find(){

        $todos = $this->app->db->find("addons/todos");
        
        return json_encode($todos);
    }
    
    public function save(){

        $todo = $this->param("todo", null);

        if($todo) {

            $todo["modified"] = time();
            $todo["_uid"]     = $this->user["_id"];

            if(!isset($todo["_id"])){
                $todo["created"] = $todo["modified"];
            }

            $this->app->db->save("addons/todos", $todo);
        }

        return $todo ? json_encode($todo) : '{}';
    }
}