<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    public function status($id){
        $faq = Faq::find($id);

        $status = $faq->status;

        switch ($status) {
            case 1:
                return '<span class="label label-success">Online</span>';
                break;
            case 2:
                return '<span class="label label-warning">Pending</span>';
                break;
            case 3:
                return '<span class="label label-primary">Drafted</span>';
                break;
            case 4:
                return '<span class="label label-info">Private</span>';
                break;
            case 5:
                return '<span class="label label-danger">Rejected</span>';
                break;
            
            default:
                return '<span class="label label-info">Undefined</span>';
                break;
        }
    }
}
