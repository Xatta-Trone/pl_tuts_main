<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\Admin\Activity;
use App\Model\Admin\Department;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index','how_to','faq','books']);
    }
    public function index(){
        $departments = Department::all();
        $level_terms = DB::table('level_terms')->distinct()->get(['slug']);
        $users = DB::table('users')->count();
        $books = DB::table('books')->count();
        $downloads = DB::table('activities')->where('activity','downloaded')->count();
        $utilities = DB::table('utilities')->first();
        $testimonials = DB::table('testimonials')->where('status',1)->orderBy('id','desc')->get();
        //dd($utilities);

        return view('user.home',compact('users','books','downloads','utilities','testimonials','departments','level_terms'));
    } 


    public function search(){
        SEOMeta::setTitle('Search');
        OpenGraph::setTitle('Search');
    	return view('user.search');
    }


    public function softwares(){
        $softwares = DB::table('softwares')->where('status',1)->orderBy('id','desc')->get();
        //dd($softwares);
        //seo data
        $description = [];
        //all description
        foreach ($softwares as $s) {
           $description[] = $s->description;
        }
        //dd($description);

        SEOMeta::setTitle('Softwares');
        SEOMeta::addKeyword(implode(',', $description));
        SEOMeta::setDescription(implode(' ', $description));

        OpenGraph::setTitle('Softwares');
        OpenGraph::setDescription(implode(' ', $description));
        OpenGraph::addProperty('type', 'article');

    	return view('user.softwares',compact('softwares'));
    }

    
    public function how_to(){
        SEOMeta::setTitle('How to');
        OpenGraph::setTitle('How to');
    	return view('user.howto');
    }


    public function books(){
        $books = DB::table('books')->where('status',1)->orderBy('id','desc')->get();
        //seo data
        $description = [];
        //all description
        foreach ($books as $s) {
           $description[] = $s->description;
        }
        //dd($description);

        SEOMeta::setTitle('Books');
        SEOMeta::addKeyword(implode(',', $description));
        SEOMeta::setDescription(implode(' ', $description));

        OpenGraph::setTitle('Books');
        OpenGraph::setDescription(implode(' ', $description));
        OpenGraph::addProperty('type', 'article');
    	return view('user.books',compact('books'));
    }
    
    public function faq(){
        SEOMeta::setTitle('Frequently asked questions');
        OpenGraph::setTitle('Frequently asked questions');
        $faqs = DB::table('faqs')->where('status',1)->orderBy('id','desc')->get();
        return view('user.faq',compact('faqs'));
    }

    public function trending(){
        return view('user.trending');
    }

}
