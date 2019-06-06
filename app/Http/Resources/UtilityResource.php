<?php
namespace App\Http\Resources;


use League\Fractal;


class UtilityResource  extends Fractal\TransformerAbstract
{
	public function transform($data)
	{
	    return [
	        'email'=> $data['utilites']->email,
	    ];
	}

}

