<?php
namespace App\Http\Resources;


use App\Http\Resources\CourseResource;
use Illuminate\Support\Facades\Request;
use League\Fractal;


class LevelTermResource  extends Fractal\TransformerAbstract
{
	public function transform($data)
	{
	    return [
	        'name' => $data->name,
	        'slug' => $data->slug,
	        'link' => config('app.url').'/'.Request::path().'/'.$data->slug,
	        'courses' => isset($data->course) ? fractal($data->course, new CourseResource())->toArray() : 'null'
	    ];
	}

}

