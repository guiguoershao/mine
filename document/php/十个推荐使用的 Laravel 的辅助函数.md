
#### array_dot()
* array_dot() array_dot () 辅助函数允许你将多维数组转换为使用点符号的一维数组。
```
$array = [
    'user' => ['username' => 'something'],
    'app' => ['creator' => ['name' => 'someone'], 'created' => 'today']
];

$dot_array = array_dot($array);

// [user.username] => something, [app.creator.name] => someone, [app.created] => today
```

#### array_get()
* array_get() 函数使用点符号从多维数组中检索值。

```
$array = [
    'user' => ['username' => 'something'],
    'app' => ['creator' => ['name' => 'someone'], 'created' => 'today']
];

$name = array_get($array, 'app.creator.name');

// someone

// 如果 key 不存在，array_get() 函数还接受可选的第三个参数作为默认值。

$name = array_get($array, 'app.created.name', 'anonymous');

// anonymous

```

#### public_path()
* public_path() 返回 Laravel 应用程序中公共目录的完全限定的绝对路径。 你还可以将路径传递到公共目录中的文件或目录以获取该资源的绝对路径。 它将简单地将 public_path() 添加到你的参数中。
```
$public_path = public_path();

$path = public_path('js/app.js');
Str::orderedUuid()
Str::orderedUuid() 函数首先生成一个时间戳 uuid。 这个 uuid 可以存储在索引数据库列中。 这些 uuid 是基于时间戳创建的，因此它们会保留你的内容索引。 在 Laravel 5.6 中使用它时，会引发 Ramsey\Uuid\Exception\UnsatisfiedDependencyException。 要解决此问题，只需运行以下命令即可使用 moontoast/math 包：:

composer require "moontoast/math"
use Illuminate\Support\Str;

return (string) Str::orderByUuid()

// A timestamp first uuid
str_plural()
str_plural 函数将字符串转换为复数形式。该功能只支持英文。

echo str_plural('bank');

// banks

echo str_plural('developer');

// developers
```

* 转载来源 https://learnku.com/laravel/t/27673