<?php
namespace App\Http\Resources;


use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Request;
use League\Fractal;


class CourseResource  extends Fractal\TransformerAbstract
{
	public function transform($data)
	{
	    return [
	        'name' => $data->course_name,
	        'slug' => $data->slug,
	        'link' => config('app.url').'/'.Request::path().'/'.$data->slug,
	        'posts'=> isset($data->posts) ? fractal($data->posts, new PostResource())->toArray() : 'null'
	    ];
	}

}

