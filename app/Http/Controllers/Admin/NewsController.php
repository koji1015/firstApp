<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News;
use App\Profile;

class NewsController extends Controller
{
 
  public function add()
  {
      return view('admin.news.create');
  }

  public function create(Request $request)
  {
    $this->validate($request,News::$rules);

    $news = News;
    $from = $request->all();

    if(isset($from['image'])){
      $path = $request->file('image')->store('public/image');
      $news->image_path = basename($path);
    }else{
      $news->image_path = null;
    }

    unset($from['_token']);

    unset($from['image']);

    $news->fill($from);
    $news->save();
      
      return redirect('admin/news/create');
  }  

  public function index(Request $request)
  {
    $cond_title = $request->cond_title;
    if(cond_title !=''){
      $posts = News::where('title',$cond_title)->get(); 
    }else{
      $posts = News::all();
    }

    return view('admin,news,index',['posts,'=> $posts,'cond_title' =>$cond_title]);
  }

}
