<?php

//API
$this->module("todos")->extend([

    "todos" => function() use($app) {

        $todos = $app->db->getCollection("addons/todos");
    
        if($todos) {
            return $todos;
        }
    }
]);

if(!function_exists("todos")) {
    function todos() {
        return cockpit("todos")->todos();
    }
}

// ADMIN
if(COCKPIT_ADMIN) {
    
    $app->on("admin.init", function() use($app){
        
        // bind routes
        $app->bindClass("Todos\\Controller\\Todos", "todos");
        
        // bind api
        $app->bindClass("Todos\\Controller\\Api", "api/todos");
        
        // menu item
        $app("admin")->menu("top", [
            "url"    => $app->routeUrl("/todos"),
            "label"  => '<i class="uk-icon-tasks"></i>',
            "title"  => $app("i18n")->get("Todos"),
            "active" => (strpos($app["route"], '/todos') === 0)
        ], -1);
        
    });
    
}