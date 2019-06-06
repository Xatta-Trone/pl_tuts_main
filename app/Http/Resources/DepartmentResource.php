<?php
namespace App\Http\Resources;


use App\Http\Resources\LevelTermResource;
use League\Fractal;


class DepartmentResource  extends Fractal\TransformerAbstract
{
	public function transform($data)
	{
	    return [
	        'dept_name' => $data->dept_name,
	        'dept_code' => $data->dept_code,
	        'slug' => $data->slug,
	        'image' => config('app.url').'/storage/departments/'.$data->image,
	        'levelterms' => isset($data->levelterms) ? fractal($data->levelterms, new LevelTermResource())->toArray() : 'null'
	    ];
	}

}

