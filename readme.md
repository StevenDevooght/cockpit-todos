#Installation

1. Create a subfolder in the modules/addons folder of your cockpit installation (e.g. Todos).
2. Copy the contents of this repository in the subfolder you just created.
3. The addon is ready to be used and accessible from within the cockpit admin menu.

#Usage

All query methods available on cockpit collections can be used to query todos.

###Query all todos

```php
$todos = todos()->find()->toArray();
```

###Query specific todos

```php
$todos = todos()->find(["done" => true])->toArray();
```