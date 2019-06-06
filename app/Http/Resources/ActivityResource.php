<?php
namespace App\Http\Resources;


use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Request;
use League\Fractal;


class ActivityResource  extends Fractal\TransformerAbstract
{
	public function transform($data)
	{
	    return [
	        'id' => $data->id,
	        'activity' => $data->activity,
	        'model' => $data->model,
	        'model_id' => $data->model_id,
	        'label' => $data->label,
	        'created_at' => $data->created_at,
	    ];
	}

}

