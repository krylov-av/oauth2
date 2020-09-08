#Миграции и наполнение данными

Реализовать базу данных блога (пользователи, посты, категории, тэги) и заполните её фейковыми данными.

---

##Задание 1. Создание готовой фабрики

В файле DatabaseSeeder.php [сгенерировать](https://laravel.com/docs/7.x/database-testing#persisting-models "Persisting Models") 10 пользователей используя уже готовую фабрику UserFactory.

---

Задание 2. Реализовать миграцию и фабрику для модели Post.

2.1. С помощью команды php artisan [создать модель](https://laravel.com/docs/7.x/eloquent#defining-models "Defining Models") Post и сразу же миграцию к ней.

2.2. Реализовать миграцию для таблицы posts, используя встроенные [методы](https://laravel.com/docs/7.x/migrations#creating-columns "Creating Columns").
  - id BIG INT UNSIGNED AUTO_INCREMENT
  - user_id BIG INT UNSIGNED
  - title VARCHAR(255)
  - body TEXT
  - status BOOL DEFAULT 'false'
  - created_at TIMESTAMP
  - updated_at TIMESTAMP

Поле user_id сделать [внешним ключём](https://laravel.com/docs/7.x/migrations#foreign-key-constraints "Foreign Key Constraints") к таблице users (полю id).

2.3. Определить [отношения](https://laravel.com/docs/7.x/eloquent-relationships "Eloquent: Relationships") между таблицами users и posts и в соответствующих моделях прописать методы-связи.

2.4. Создать [фабрику](https://laravel.com/docs/7.x/database-testing#writing-factories "Writing Factories") для модели Post при помощи [команды artisan](https://laravel.com/docs/7.x/database-testing#generating-factories "Generating Factories"). Фабрика должна быть написана так, чтобы при создании поста создавался и User.

2.5. Применить фабрику для создания постов и в DatabaseSeeder.php создать 10 пользователей и [для каждого из них по 10 постов](https://laravel.com/docs/7.x/database-testing#relationships "Relationships").

---

Задание 3. Реализовать миграцию и фабрику для модели Category (категория поста).

3.1. С помощью [команды artisan](https://laravel.com/docs/7.x/eloquent#defining-models "Defining Models") создать модель Category и сразу же миграцию к ней (показано на уроке).

3.2. Реализовать миграцию для таблицы categories, используя встроенные [методы](https://laravel.com/docs/7.x/migrations#creating-columns "Creating Columns")
  - id BIG INT UNSIGNED AUTO_INCREMENT
  - title VARCHAR(255)
  - slug VARCHAR(255)
  - created_at TIMESTAMP
  - updated_at TIMESTAMP

3.3. [Создайте миграцию](https://laravel.com/docs/7.x/migrations#generating-migrations "Generating Migrations") для модификации таблицы posts. Назовите миграцию соответствующим образом, чтобы было понятно её предназначение. [Добавьте поле](https://laravel.com/docs/7.x/migrations#creating-columns "Creating Columns") принадлежности категории:
  - category_id BIG INT UNSIGNED, после user_id

Для category_id реализовать [внешний ключ](https://laravel.com/docs/7.x/migrations#foreign-key-constraints "Foreign Key Constraints").

3.4. Определите [отношения](https://laravel.com/docs/7.x/eloquent-relationships "Eloquent: Relationships") между моделями Post и Category и реализуйте в обеих моделях связные методы.

3.5. Создайте [фабрику](https://laravel.com/docs/7.x/database-testing#writing-factories "Writing Factories") для модели Category. При создании отдельной категории должен создаваться и Post. В поле slug запишите то же значение, что и в title, только пропустите его через функцию [str_slug](https://laravel.com/docs/5.2/helpers#method-str-slug) (для этого подгрузить пакет ```composer require laravel/helpers```).

3.6. Преобразуйте файл DatabaseSeeder.php следующим образом:
  - Создайте 10 категорий (получится коллекция)
  - При создании поста прикрепите ему случайную категорию (можно использовать метод [random](https://laravel.com/docs/7.x/collections#method-random) от коллекции категорий)

---

Задание 4. Реализовать миграцию и фабрику для модели Tag (теги поста).

4.1. С помощью [команды artisan](https://laravel.com/docs/7.x/eloquent#defining-models "Defining Models") создать модель Tag и сразу же миграцию к ней.

4.2. Создать миграцию для таблицы tags, используя встроенные [методы](https://laravel.com/docs/7.x/migrations#creating-columns "Creating Columns")
  - id BIG INT UNSIGNED AUTO_INCREMENT
  - title VARCHAR(255)
  - slug VARCHAR(255)
  - created_at TIMESTAMP
  - updated_at TIMESTAMP

4.3. Создать миграцию для таблицы post_tag (без модели), используя встроенные [методы](https://laravel.com/docs/7.x/migrations#creating-columns "Creating Columns")
  - id BIG INT UNSIGNED AUTO_INCREMENT
  - post_id BIG INT UNSIGNED
  - tag_id BIG INT UNSIGNED
  - created_at TIMESTAMP
  - updated_at TIMESTAMP

Для post_id и tag_id необходимо реализовать [внешние ключи](https://laravel.com/docs/7.x/migrations#foreign-key-constraints "Foreign Key Constraints").

4.4. Определите [отношения](https://laravel.com/docs/7.x/eloquent-relationships "Eloquent: Relationships") между моделями Post и Tag. Реализуйте в обеих моделях связные методы.

4.5. Создайте [фабрику](https://laravel.com/docs/7.x/database-testing#writing-factories "Writing Factories") для модели Tag аналогично посту.

4.6. Преобразуйте файл DatabaseSeeder.php следующим образом:

- Создайте 20 тэгов (получится коллекция )
- После создания постов привяжите каждому посту от 3 до 5 тэгов. Можете использовать тот же метод [random](https://laravel.com/docs/7.x/collections#method-random) в сочетании с методом [pluck](https://laravel.com/docs/7.x/collections#method-pluck) и для сохранения связи метод [attach](https://laravel.com/docs/7.x/eloquent-relationships#updating-many-to-many-relationships).

В итоге запуск команды ```php artisan migrate:fresh --seed``` должен заполнить таблицу users, posts, categories, tags, post_tag.

**На 100 баллов**

5. Реализуйте для каждой модели (User, Post, Category, Tag) свой [seed-файл](https://laravel.com/docs/7.x/seeding#writing-seeders "Writing Seeders") (для [отдельного запуска](https://laravel.com/docs/7.x/seeding#running-seeders "Running Seeders") каждой фабрики).