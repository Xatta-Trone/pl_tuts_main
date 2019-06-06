<?php
namespace App\Http\Resources;


use Illuminate\Support\Facades\Request;
use League\Fractal;


class PostResource  extends Fractal\TransformerAbstract
{
	public function transform($data)
	{
	    return [
	        'name' => $data->name,
	        'author' => $data->author,
	        'department_slug' => $data->department_slug,
	        'level_term_slug' => $data->level_term_slug,
	        'post_type' => $data->post_type,
	        'link' => $data->link,
	        'image' => $data->image,
	        'custom_message' => $data->custom_message,
	        // 'link' => config('app.url').'/'.Request::path().'/'.$data->slug,
	    ];
	}

}

