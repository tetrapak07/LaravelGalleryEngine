<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Albom;
use App\Models\Category;
use App\Models\Image;
use App\Models\Page;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        /* allow mass assigments */
        //Model::unguard(); 

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        $this->call('UsersTableSeeder');
        $this->call('SettingsTableSeeder');
        $this->call('CategoriesTableSeeder');
        $this->call('AlbomsTableSeeder');
        $this->call('AlbomsCategoriesTableSeeder');
        $this->call('ImagesTableSeeder');
        $this->call('PagesTableSeeder');
        $this->call('VkappsTableSeeder');
        $this->call('VkappsTableSeeder');
        $this->call('VkparsersTableSeeder');

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

}

class UsersTableSeeder extends Seeder {

    public function run() {

        DB::table('users')->truncate();

        User::create([
            'email' => 'admin@gmail.com',
            'name' => 'admin',
            'password' => bcrypt("admin"),
        ]);
        User::create([
            'email' => 'admin@mail.ru',
            'name' => 'root',
            'password' => bcrypt("root"),
        ]);
    }

}

class SettingsTableSeeder extends Seeder {

    public function run() {

        DB::table('settings')->truncate();

        $settings = array(
            ['id' => 1, 'name' => 'uri_site', 'value' => URL::to('/'),
                'description' => 'Базовый адрес сайта',
                'created_at' => new DateTime, 'updated_at' => new DateTime
            ],
            ['id' => 2, 'name' => 'domain', 'value' => Request::server('HTTP_HOST'),
                'description' => 'Базовый домен сайта',
                'created_at' => new DateTime, 'updated_at' => new DateTime
            ],
            ['id' => 3, 'name' => 'site_name', 'value' => 'Имя сайта',
                'description' => 'Название сайта',
                'created_at' => new DateTime, 'updated_at' => new DateTime
            ],
            ['id' => 4, 'name' => 'title', 'value' => 'Тайтл',
                'description' => 'Основная часть заголовка сайта',
                'created_at' => new DateTime, 'updated_at' => new DateTime
            ],
            ['id' => 5, 'name' => 'description', 'value' => 'Описание сайта',
                'description' => 'Основное описание сайта',
                'created_at' => new DateTime, 'updated_at' => new DateTime
            ],
            ['id' => 6, 'name' => 'keywords', 'value' => 'ключевое, слово, тест1',
                'description' => 'Основная часть ключевых слов сайта',
                'created_at' => new DateTime, 'updated_at' => new DateTime
            ],
            ['id' => 7, 'name' => 'main_page_h2', 'value' => 'Оглавление главной страницы',
                'description' => 'Оглавление главной страницы',
                'created_at' => new DateTime, 'updated_at' => new DateTime
            ]
        );

        DB::table('settings')->insert($settings);
    }

}

class CategoriesTableSeeder extends Seeder {

    public function run() {

        DB::table('categories')->truncate();
        foreach (range(1, 44) as $num) {
            Category::create([
                'title' => 'category title ' . $num,
                'slug' => 'category-slug-' . $num,
            ]);
        }
    }

}

class AlbomsTableSeeder extends Seeder {

    public function run() {

        DB::table('alboms')->truncate();
        foreach (range(1, 100) as $num) {
            ( $num % 2 ) ? $thumb = 'https://pp.vk.me/c621831/v621831748/aa42/abIjoO-w7hM.jpg' : $thumb = 'https://pp.vk.me/c310523/v310523674/dfc/QgQ3eE0TMTY.jpg';
            Albom::create([
                'title' => 'albom title ' . $num,
                'slug' => 'albom-slug-' . $num,
                'thumb' => $thumb
            ]);
        }
    }

}

class AlbomsCategoriesTableSeeder extends Seeder {

    public function run() {
        DB::table('alboms_categories')->truncate();

        foreach (range(1, 100) as $num) {
            $albom = Albom::find($num);
            $albom->categories()->sync([rand(1, 24), rand(25, 44)]);
        }
    }

}

class ImagesTableSeeder extends Seeder {

    public function run() {

        DB::table('images')->truncate();
        foreach (range(1, 1000) as $num) {
            Image::create([
                'albom_id' => (ceil($num / 10)),
                'title' => 'image title ' . $num,
                'slug' => 'image-slug-' . $num,
                'width' => 2048,
                'height' => 1536,
                'url_thumb' => 'http://cs540108.vk.me/c7007/v7007001/27313/NBZHcqJpIzk.jpg',
                'url' => 'http://cs540108.vk.me/c7007/v7007001/27317/XH3CdVyxWRs.jpg',
                'ext' => 'jpg',
                'file_type' => 'image/jpeg',
                'file_size' => '256 KB'
            ]);
        }
    }

}

class PagesTableSeeder extends Seeder {

    public function run() {

        DB::table('pages')->truncate();
        foreach (range(1, 44) as $num1) {
            foreach (range(1, 25) as $num2) {
                Page::create([
                    'category_id' => $num1,
                    'page_number' => $num2,
                    'title' => 'page title ' . $num1 . $num2,
                ]);
            }
        }
    }

}

class VkappsTableSeeder extends Seeder {

    public function run() {

        DB::table('vkapps')->truncate();

        $vkapp = array(
            ['id' => 1, 'app_id' => 4789045, 'app_secret' => 'gkjluodFVnmlgoh',
                'access_rights' => 'friends,video,audio,offline,wall,groups,photos,notes,pages',
                'app_token' => '',
                'created_at' => new DateTime, 'updated_at' => new DateTime
            ]
        );

        DB::table('vkapps')->insert($vkapp);
    }

}

class VkparsersTableSeeder extends Seeder {

    public function run() {

        DB::table('vkparsers')->truncate();

        $vkparser = array(
            ['id' => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ]
        );

        DB::table('vkparsers')->insert($vkparser);
    }

}
