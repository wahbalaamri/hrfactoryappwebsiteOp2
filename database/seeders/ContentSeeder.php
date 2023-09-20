<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //get content from Api
        $contents = json_decode(file_get_contents('http://localhost:1148/Home/shipContents'), true);
        //insert content to database
        foreach ($contents as  $content) {
            $new_content = new Content();
            $new_content->d_id = $content['Id'];
            $new_content->ArabicText = $content['ArabicText'];
            $new_content->EnglishText = $content['EnglishText'];
            $new_content->save();
        }
        echo "seeding done";
        $test = Content::whereIn('d_id', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 47, 48, 49, 50, 122, 123, 124, 125])->update(['page' => 'home']);
        Log::info("seeding done");
    }
}
