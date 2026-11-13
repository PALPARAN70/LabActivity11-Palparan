<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach (Post::where('is_published', true)->get() as $post) {
            $howMany = rand(0, 5);

            if ($howMany > 0) {
                Comment::factory()->count($howMany)
                    ->for($post)
                    ->sequence(fn ($seq) => ['user_id' => $users->random()->id])
                    ->create();
            }
        }

        $pinned = Post::where('is_pinned', true)->firstOrFail();
        $lola   = User::where('email', 'lola.palparan@bulletin.test')->firstOrFail();

        $pinned->comments()->create([
            'user_id' => $lola->id,
            'body'    => 'Moadto ko ugma, dad-on nako akong silhig. Salamat Kagawad!',
        ]);

        $pinned->comments()->create([
            'user_id' => $users->random()->id,
            'body'    => 'Unsa oras magsugod? Naa koy trabaho sa buntag.',
        ]);

        $pinned->comments()->create([
            'user_id' => $users->random()->id,
            'body'    => 'Apil mi sa among kilid sa kanal. Magdala ko og sako.',
        ]);
    }
}