<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $post1 = Post::create([
            'user_id' => $users->random()->id,
            'title' => 'Новые возможности Laravel 11',
            'body' => 'Laravel 11 обещает быть еще более производительным и удобным. Разработчики добавили множество новых фич, которые упрощают разработку.',
        ]);
        $post1->comments()->createMany([
            ['user_id' => $users->random()->id, 'body' => 'Да, я уже слышал про это! Особенно радует обновленный Breeze.'],
            ['user_id' => $users->random()->id, 'body' => 'Жду не дождусь, чтобы попробовать его в своих проектах.'],
        ]);

        $post2 = Post::create([
            'user_id' => $users->random()->id,
            'title' => 'Почему JavaScript так популярен?',
            'body' => 'JavaScript стал краеугольным камнем веб-разработки. Он везде: от фронтенда до бэкенда. Его гибкость и огромное сообщество делают его незаменимым.',
        ]);
        $post2->comments()->createMany([
            ['user_id' => $users->random()->id, 'body' => 'Согласен, без него никуда. Но иногда его асинхронность сводит с ума.'],
            ['user_id' => $users->random()->id, 'body' => 'TypeScript — отличное решение, чтобы справиться с этой проблемой.'],
            ['user_id' => $users->random()->id, 'body' => 'Надеюсь, что когда-нибудь его заменят чем-то более удобным.'],
        ]);

        $post3 = Post::create([
            'user_id' => $users->random()->id,
            'title' => 'Мое путешествие в Исландию',
            'body' => 'Исландия — это место, где природа показывает свою мощь. Ледники, вулканы, горячие источники... Это было незабываемо.',
        ]);
        $post3->comments()->createMany([
            ['user_id' => $users->random()->id, 'body' => 'Вау, звучит круто! Какое место понравилось больше всего?'],
            ['user_id' => $users->random()->id, 'body' => 'Мечтаю туда поехать!'],
        ]);

        $post4 = Post::create([
            'user_id' => $users->random()->id,
            'title' => 'Рецепт идеального чизкейка',
            'body' => 'Хотите приготовить чизкейк, который будет таять во рту? Мой секрет — использование сливочного сыра только комнатной температуры.',
        ]);
        $post4->comments()->createMany([
            ['user_id' => $users->random()->id, 'body' => 'Спасибо за рецепт! Попробую на выходных.'],
            ['user_id' => $users->random()->id, 'body' => 'А можно заменить сливочный сыр на что-то другое?'],
            ['user_id' => $users->random()->id, 'body' => 'Выглядит очень аппетитно!'],
        ]);

        $post5 = Post::create([
            'user_id' => $users->random()->id,
            'title' => 'Обзор MacBook Pro 16"',
            'body' => 'Новый MacBook Pro с чипом M3 — это зверь! Производительность просто зашкаливает. Идеален для разработчиков и дизайнеров.',
        ]);
        $post5->comments()->createMany([
            ['user_id' => $users->random()->id, 'body' => 'Да, цена кусается, но оно того стоит.'],
            ['user_id' => $users->random()->id, 'body' => 'А как насчет времени автономной работы?'],
        ]);

        $post6 = Post::create([
            'user_id' => $users->random()->id,
            'title' => '10 лучших книг по саморазвитию',
            'body' => 'От "7 навыков высокоэффективных людей" до "Атомных привычек". Эти книги изменят ваше отношение к жизни.',
        ]);
        $post6->comments()->createMany([
            ['user_id' => $users->random()->id, 'body' => 'Отличная подборка! "Атомные привычки" — моя любимая.'],
            ['user_id' => $users->random()->id, 'body' => 'А что насчет "Думай и богатей"?'],
            ['user_id' => $users->random()->id, 'body' => 'Спасибо за рекомендации, добавлю в свой список чтения.'],
        ]);

        $post7 = Post::create([
            'user_id' => $users->random()->id,
            'title' => 'Путешествие по Транссибирской магистрали',
            'body' => 'Это было самое долгое и увлекательное путешествие в моей жизни. 7 дней в поезде, проезжая всю страну — это невероятный опыт.',
        ]);
        $post7->comments()->createMany([
            ['user_id' => $users->random()->id, 'body' => 'Звучит как настоящее приключение!'],
            ['user_id' => $users->random()->id, 'body' => 'Я бы не выдержал так долго в поезде.'],
        ]);

        $post8 = Post::create([
            'user_id' => $users->random()->id,
            'title' => 'Где найти вдохновение для кода?',
            'body' => 'Иногда бывает "выгорание". Лучший способ — отвлечься, погулять, посмотреть на работы других разработчиков.',
        ]);
        $post8->comments()->createMany([
            ['user_id' => $users->random()->id, 'body' => 'Да, это очень важная тема. Мне помогает спорт.'],
            ['user_id' => $users->random()->id, 'body' => 'Иногда помогает просто посмотреть обучающие видео на YouTube.'],
            ['user_id' => $users->random()->id, 'body' => 'Полностью согласен. Главное — не сдаваться.'],
        ]);

        $post9 = Post::create([
            'user_id' => $users->random()->id,
            'title' => 'Рецепт простого и вкусного супа',
            'body' => 'Этот суп можно приготовить за 30 минут. Идеально, когда нет времени, но хочется чего-то горячего и домашнего.',
        ]);
        $post9->comments()->createMany([
            ['user_id' => $users->random()->id, 'body' => 'Очень нужен такой рецепт!'],
            ['user_id' => $users->random()->id, 'body' => 'Звучит как рецепт для ленивых. Мне нравится!'],
        ]);

        $post10 = Post::create([
            'user_id' => $users->random()->id,
            'title' => 'Что такое CI/CD и почему это важно?',
            'body' => 'Непрерывная интеграция и доставка — это ключ к быстрой и надежной разработке. Это автоматизация, которая спасает много времени.',
        ]);
        $post10->comments()->createMany([
            ['user_id' => $users->random()->id, 'body' => 'Наконец-то кто-то объяснил это просто!'],
            ['user_id' => $users->random()->id, 'body' => 'В моей компании это уже давно используют.'],
        ]);
    }
}
