<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        
        Post::truncate();

        //random enum para posted
        $rPosted = ['yes','no'];
        //

        for ($i = 1; $i < 30 ; $i++) { 
            

            //random de category sacado de la tabla categorias creada, luego random title
            $c = Category::inRandomOrder()->first();
            $title = Str::random(20);

            Post::create
            (
                [
                    'title' =>  $title,
                    'slug' => Str::slug($title),
                    'category_id' => $c->id,
                    'posted' => $rPosted[rand(0,1)],
                    'content' => "Contenido $i",
                    'description' => "Descripcion $i",

                    //solo para ver
                   // protected $fillable = ['title', 'slug', 'category_id', 'posted', 'content', 'description', 'image'];
                ]
            );
        }
        Schema::enableForeignKeyConstraints();
    }
}