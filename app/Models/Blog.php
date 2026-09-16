<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{


    //Aqui la idea es definir los campos para que yo desde mi web Dashboard puesda gestionar el contenido.
    protected $fillable = [
        'title',
        'image',
        'content',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'link',
        'author_id',
    ];
}
