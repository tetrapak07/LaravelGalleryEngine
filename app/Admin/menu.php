<?php

/*
 * Admin menu (icons and urls)
 */

Admin::menu()->url('/')->label('Start page')->icon('fa-dashboard');

Admin::menu()->url('settings')->label('Настройки')->icon('fa-cog');

Admin::menu()->url('categories')->label('Категории')->icon('fa-folder-o');

Admin::menu()->url('alboms')->label('Альбомы')->icon('fa-picture-o');

Admin::menu()->url('pages')->label('Страницы')->icon('fa-square-o');

Admin::menu()->url('images')->label('Фотографии')->icon('fa-photo');

Admin::menu()->url('vk_parser')->label('Парсер (ВК)')->icon('fa-vk');

Admin::menu()->url('meta_auto')->label('Автогенерация метаописаний')->icon('fa-bolt');


