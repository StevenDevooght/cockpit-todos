<div id="todos" ng-controller="todos">

    <div class="uk-navbar">
        <span class="uk-navbar-brand">@lang('Todos')</span>
        <ul class="uk-navbar-nav">
            <li><a href ng-click="addTodo()" title="@lang('Add todo')" data-uk-tooltip="{pos:'right'}" data-cached-title="Add collection"><i class="uk-icon-plus-circle"></i></a></li>
        </ul>
    </div>

    <div class="app-panel uk-margin uk-text-center ng-hide" data-ng-show="todos && !todos.length">
        <h2><i class="uk-icon-tasks"></i></h2>
        <p class="uk-text-large">
            @lang('It seems you don\'t have any todo entries.')
        </p>
    </div>

    <div class="uk-grid" data-uk-grid-margin="" data-ng-show="todos && todos.length">
        <div class="uk-width-medium-4-5">
            <div class="app-panel">
                <table class="uk-table uk-table-striped">
                    <thead>
                        <tr>
                            <th width="10"></th>
                            <th>
                                @lang('Title')                            
                            </th>
                            <th width="15%">@lang('Last modified')</th>
                            <th width="15%">@lang('Created')</th>
                            <th width="10%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-ng-repeat="todo in todos">
                            <td><input type="checkbox" ng-model="todo.done" ng-change="todoDone(todo)" /></td>
                            <td>
                                @@ todo.title @@
                            </td>
                            <td>@@ todo.modified | fmtdate:'d M, Y' @@</td>
                            <td>@@ todo.created | fmtdate:'d M, Y' @@</td>
                            <td class="uk-text-right">
                                <a href data-ng-click="editTodo(todo)" title="@lang('Edit entry')"><i class="uk-icon-pencil"></i></a>
                                <a href data-ng-click="removeTodo(todo)" title="@lang('Delete entry')"><i class="uk-icon-trash-o"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>

    App.module.controller("todos", function($scope, $rootScope, $http, $timeout) {

        fetchTodos();

        $scope.todos;

        $scope.newTodo = '';

        $scope.addTodo = function() {
            var title = prompt(App.i18n.get("Please enter a title:"), "");

            if (!title.length) {
                return;
            }

            saveTodo({
                title: title,
                done: false
            });
        };

         $scope.editTodo = function(todo) {
             var title = prompt(App.i18n.get("Please enter a title:"), todo.title);
             
             if(!title.length) {
                 return;
             }
             
             todo.title = title;
             
             saveTodo(todo);
         };

        $scope.removeTodo = function(todo) {
            App.Ui.confirm(App.i18n.get("Are you sure?"), function() {
                removeTodo(todo);
            });
        };

        $scope.todoDone = function(todo) {
            saveTodo(todo);
        };

        function saveTodo(todo) {
            $http.post(App.route("/api/todos/save"), {"todo": todo}).success(function(data) {
                if (!todo._id) {
                    $scope.todos.push(data);
                }
            });
        };

        function removeTodo(todo) {
            $http.post(App.route("/api/todos/remove"), {"id": todo._id}).success(function(data) {
                $scope.todos.splice($scope.todos.indexOf(todo), 1);
            });
        };

        function fetchTodos() {
            $http.post(App.route("/api/todos/find")).success(function(data) {
                $scope.todos = data;
            });
        };

    });

</script>