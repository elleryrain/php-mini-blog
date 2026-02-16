<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{

    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'Как я организовал рабочий день разработчика',
            '5 ошибок при изучении Laravel',
            'Почему я перешел на PostgreSQL',
            'Минимальный стек для пет-проекта в 2026',
            'Как писать читаемые миграции',
        ];

        $excerpts = [
            'Коротко о практиках, которые реально экономят время.',
            'Разбираю частые ошибки новичков и как их избежать.',
            'Что понравилось в Postgres после MySQL.',
            'Набор инструментов без лишней сложности.',
            'Простой подход к структуре базы данных.',
        ];

        $bodies = [
            "В этой статье расскажу, как я планирую задачи и избегаю перегрузки.\n\nСначала определяю 1-2 главные цели на день, затем разбиваю их на короткие шаги по 25-40 минут. Такой подход помогает не застревать в мелочах.",
            "Laravel кажется простым, но есть несколько типичных ловушек: отсутствие валидации, смешивание бизнес-логики с контроллерами и игнорирование тестов.\n\nЕсли вынести логику в сервисы и requests, код становится гораздо чище.",
            "После перехода на PostgreSQL я заметил более предсказуемую работу с типами и удобные индексы.\n\nДля блога это полезно, когда появляются фильтры, поиск и сортировки.",
            "Для небольшого проекта мне хватает Laravel, Blade, Tailwind и PostgreSQL.\n\nГлавное правило: сначала сделать MVP, потом постепенно улучшать архитектуру.",
            "Миграции должны быть понятными и самодостаточными.\n\nХорошая практика — явно задавать ограничения, индексы и внешний ключ, чтобы структура БД оставалась прозрачной.",
        ];

        $title = fake()->randomElement($titles);

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1000, 9999),
            'excerpt' => fake()->randomElement($excerpts),
            'body' => fake()->randomElement($bodies),
            'image_path' => null,
            'published_at' => now()->subDays(fake()->numberBetween(0, 30)),
        ];
    }
}
