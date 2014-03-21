<style>
    #todo-list li form {
        display: none;
    }
    #todo-list li.editing .view {
        display: none;
    }
    #todo-list li.editing form {
        display: block;
    }
</style>

<div id="todos" ng-controller="todos">
    <div class="uk-navbar">
        <span class="uk-navbar-brand">Todos</span>
        <ul class="uk-navbar-nav">
            <li><a href ng-click="addTodo()" title="@lang('Add todo')" data-uk-tooltip="{pos:'right'}" data-cached-title="Add collection"><i class="uk-icon-plus-circle"></i></a></li>
        </ul>
    </div>
    <div class="app-panel">
        <div ng-show="todos.length">
            <ul id="todo-list">
                <li ng-repeat="todo in todos" ng-class="{editing: todo == editedTodo}">
                    <div class="view">
                        <input type="checkbox" ng-model="todo.done" ng-change="todoDone(todo)" />
                        <label ng-dblclick="editTodo(todo)">@@ todo.title @@</label>
                        <button class="destroy" ng-click="removeTodo(todo)">✖</button>
                    </div>
                    <form ng-submit="doneEditing(todo)">
                        <input type="text" ng-model="todo.title" ng-blur="doneEditing(todo)" />
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
    
    App.module.controller("todos", function($scope, $rootScope, $http, $timeout){
        
        fetchTodos();
        
        var todos = $scope.todos = [];
        
        $scope.newTodo = '';
        
        $scope.addTodo = function () {
            
            var title = prompt(App.i18n.get("Please enter a title:"), "");
            
            if(!title.length){
                return;
            }
            
            saveTodo({
                title: title,
                done: false
            });
            
        };
        
        $scope.editTodo = function(todo) {
            $scope.editedTodo = todo;
        };
        
        $scope.removeTodo = function(todo) {
            todos.splice(todos.indexOf(todo), 1);
        };
        
        $scope.doneEditing = function(todo) {
            $scope.editedTodo = null;
        };
        
        $scope.todoDone = function(todo) {
            saveTodo(todo);
        };
        
        function saveTodo(todo){
            $http.post(App.route("/api/todos/save"), {"todo": todo}).success(function(data){
                if(!todo._id) {
                    $scope.todos.push(todo);
                }
            });
        }
        
        function fetchTodos(){
            $http.post(App.route("/api/todos/find")).success(function(data){
                $scope.todos = data;
            });
        }
       
    });

</script>