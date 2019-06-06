<?php
namespace App\Http\Resources;


use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Request;
use League\Fractal;


class BookResource  extends Fractal\TransformerAbstract
{
	public function transform($data)
	{
	    return [
	        'name' => $data->name,
	        'author' => $data->author,
	        'department_slug' => $data->department_slug,
	        'link' => $data->link,
	        'image' => config('app.url').'/storage/books/'.$data->image,
	        'status' => $data->status,
	        'custom_message' => $data->custom_message,
	        // 'description' => $data->description,
	    ];
	}

}

