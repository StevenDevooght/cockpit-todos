<?php

namespace Todos\Controller;

class Api extends \Cockpit\Controller {

    public function find(){

        $todos = $this->app->db->find("addons/todos");
        
        return json_encode($todos->toArray());
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
    
    public function remove() {
        $id = $this->param("id", null);

        if($id) {
            $this->app->db->remove("addons/todos", ["_id" => $id]);
        }

        return $id ? '{"success":true}' : '{"success":false}';
    }
}