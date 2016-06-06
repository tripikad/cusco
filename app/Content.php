<?php

namespace App;


class Content
{
    
    protected $content;
   
    public function __construct()
    {
        
        $faker = \Faker\Factory::create();

        $this->content = collect(range(1,3))
            ->map(function($id) use ($faker) {
                return (object) [
                    'id' => $id,
                    'title' => rtrim($faker->text(30),'.'),
                    'meta' => rtrim($faker->text(30),'.'),
                    'body' => $faker->paragraph(10),
                    'comments' => collect(range(1,10))
                        ->map(function($id) use ($faker) {
                            return (object) [
                                'meta' => rtrim($faker->text(10),'.'),
                                'body' => $faker->paragraph(10),
                            ];
                        })
                ];
            });

    }

    public function get()
    {

        return $this->content;

    }

    public function find($id)
    {

        return $this->content->where('id', $id)->first();

    }

}
