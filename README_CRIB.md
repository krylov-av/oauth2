Первым делом надо посмотреть .env файл и отредактировать настроечки.
Особо уделить внимание настройкам подключения к базе

>DB_CONNECTION=mysql
>DB_HOST=mysql
>DB_PORT=3306
>DB_DATABASE=laravel
>DB_USERNAME=root
>DB_PASSWORD=secret

После запуска контейнеров надо подключиться к контейнеру php-fpm и запустить
>docker exec -it a48211f7426a bash
>composer install

После установки зависимостей нужно сгенерировать ключ
>php artisan key:generate

---
##Задание 1. Использование готовой фабрики
В файле DatabaseSeeder.php 10 пользователей используя уже готовую фабрику UserFactory.

добавляем в класс run
>$users = factory(\App\User::class, 10)->create();

После этого ресетим базу и заносим данные
>php artisan migrate:fresh --seed
---
##Задание 2. Реализовать миграцию и фабрику для модели Post.
>php artisan make:model Post -m

Создать фабрику для модели Post
>php artisan make:factory PostFactory

Фабрика должна быть написана так, чтобы при создании поста создавался и User.
>php artisan tinker
$users = factory(\App\User::class,3)->make();
$posts=factory(\App\Post::class,3)->make();

Занулим базу и посмотрим, как создается 1 пользователь и 1 Пост
$posts=factory(\App\Post::class,1)->create();

Применить фабрику для создания постов и в DatabaseSeeder.php создать 10 пользователей и для каждого из них по 10 постов.

>factory(\App\User::class, 10)->create()->each(function($user){
>   $user->posts()->saveMany(factory(\App\Post::class,10)->make(['user_id'=>$user->id]));
>});

Обнулим и засеем базу
>php artisan migrate:fresh --seed
>
---
##Задание 3. Реализовать миграцию и фабрику для модели Category (категория поста).
>php artisan make:model Category -m

Создадим миграцию, в которой добавим столбец category
>php artisan make:migration add_category_to_posts --table=posts

3.4. Определите отношения между моделями Post и Category и реализуйте в обеих моделях связные методы.
Одному посту соответствует одна категория, одной категории может соответствовать множество постов.
У модели Post добавим метод category() который вернет зависимость belongsTo
У модели Category добавим метод posts() который вернет зависимость hasMany

3.5. Создайте фабрику для модели Category
>php artisan make:factory CategoryFactory

Идем в тинкер и проверим правильность создания фабрики
>>>$categories=factory(\App\Category::class,3)->make();

Обновим фабрику posts (Добавим category_id)
проверим в тинкере как создаются Posts
>>>$posts = factory(\App\Post::class,3)->create();

Модифицируем seeder, пересоздадим и заполним данными базу
php artisan migrate:fresh --seed
---

##Задание 4. Реализовать миграцию и фабрику для модели Tag (теги поста).
>php artisan make:model Tag -m

Создадим миграцию, которая создаст таблицу-связку постов и тегов
>php artisan make:migration post_tag

Определим отношения многие-ко-многим
У модели post добавим метод tags() который вернет зависимость belongsToMany
И у модали tag добавим метод posts() который так же вернет зависимость belongsToMany

Создадим фабрику для модели tag
>php artisan make:factory TagFactory

В тинкере проверим, как все работает
>>>$tags = factory(\App\Tag::class,3)->create();

Добавим в сидер заполнение 20 тэгов
> $tags = factory(\App\Tag::class, 20)->create();

---
#1 User
Создадим отдельные сидеры
>php artisan make:seeder UserSeeder

в методе run добавим
factory(\App\User::class, 10)->create();

проверим как работает заполнение только таблицы User
>php artisan migrate:fresh
>php artisan db:seed --class=UserSeeder

#2 Category, tags
>php artisan make:seeder CategorySeeder
>php artisan make:seeder TagSeeder

добавим по аналогии
>factory(\App\Category::class,10)->create();

проверим как работает заполнение только таблицы Category
>php artisan migrate:fresh
>php artisan db:seed --class=CategorySeeder


#3 Post
>php artisan make:seeder PostSeeder
php artisan db:seed --class=PostSeeder

После этого заполнения данными, создастся 10 постов, 10 пользователей и 10 категорий.

=======================
#добавим police для модели Ad
php artisan make:policy AdPolicy --model=Ad

#debug pannel
composer require barryvdh/laravel-debugbar --dev

#добавим middleware
php artisan make:middleware CheckAdAuthor

добавить в роутер
Route::middleware(\App\Http\Middleware\CheckAdAuthor::class)
   ->get('/edit/{id?}',function($id = null){
   ...
   


=====================
OAuth ver.2
шаг 1) Создать приложение            redirect uri/callback uri
       public_key, client_id
       private_key
Шаг2) генерация ссылки
Шаг3) Запрос токена
        (?code=)
Шаг4) имея токен можно вытаскивать информацию
