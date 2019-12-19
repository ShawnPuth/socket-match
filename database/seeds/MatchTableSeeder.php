<?php

use App\Models\Dan;
use App\Models\User;
use App\Models\Season;
use App\Models\Question;
use App\Models\QuestionType;
use Illuminate\Database\Seeder;

class MatchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dan = new Dan([
            'dan_id' => 1,
            'season' => 1,
            'name' => '黑铁',
        ]);
        $dan->save();
    
        $qtype = new QuestionType([
            'name' => '天文',
            'pid' => 0,
            'desc1' => '1',
            'desc2' => '1',
        ]);
        $qtype->save();
    
        $question = new Question([
            'type_id' => 1,
            'question' => '为什么',
            'answer_a' => '123',
            'answer_b' => '123',
            'answer_c' => '123',
            'answer_d' => '123',
            'answer' => 'A',
        ]);
        $question->save();
        $question = new Question([
            'type_id' => 1,
            'question' => '为什么',
            'answer_a' => '123',
            'answer_b' => '123',
            'answer_c' => '123',
            'answer_d' => '123',
            'answer' => 'A',
        ]);
        $question->save();
        $question = new Question([
            'type_id' => 1,
            'question' => '为什么',
            'answer_a' => '123',
            'answer_b' => '123',
            'answer_c' => '123',
            'answer_d' => '123',
            'answer' => 'A',
        ]);
        $question->save();
        $question = new Question([
            'type_id' => 1,
            'question' => '为什么',
            'answer_a' => '123',
            'answer_b' => '123',
            'answer_c' => '123',
            'answer_d' => '123',
            'answer' => 'A',
        ]);
        $question->save();
        $question = new Question([
            'type_id' => 1,
            'question' => '为什么',
            'answer_a' => '123',
            'answer_b' => '123',
            'answer_c' => '123',
            'answer_d' => '123',
            'answer' => 'A',
        ]);
        $question->save();

        $season = new Season([
            'name' => 's1',
        ]);
        $season->save();

        $user = new User([
            'nick_name' => '利物浦',
            'avatar' => '231.jpg',
            'mobile' => '13012340001',
        ]);
        $user->save();
        $user = new User([
            'nick_name' => '切尔西',
            'avatar' => '231.jpg',
            'mobile' => '13012340002',
        ]);
        $user->save();
        $user = new User([
            'nick_name' => '阿森纳',
            'avatar' => '231.jpg',
            'mobile' => '13012340003',
        ]);
        $user->save();
        $user = new User([
            'nick_name' => '波尔图',
            'avatar' => '231.jpg',
            'mobile' => '13012340004',
        ]);
        $user->save();
    }
}
