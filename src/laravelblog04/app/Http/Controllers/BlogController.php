<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Http\Requests\BlogRequest;

class BlogController extends Controller
{

    /**
     * ブログ一覧を表示する
     * @return view
     */

    public function showList()
    {
        $blogs = Blog::all();
        return view('blog.list',['blogs'=>$blogs]);
    } 

    /**
     * ブログ詳細を表示する
     * @param int $id
     * @return view
     */
    public function showDetail($id)
    {
        $blog = Blog::find($id);

        if(is_null($blog)){
            \Session::flash('err_msg','データがありません。');
            return redirect(route('blogs'));
        }
        
        return view('blog.detail',['blog'=>$blog]);
    } 

    /**
     * ブログ投稿画面を表示する
     * @return view
     */

    public function showCreate()
    {
        return view('blog.form');
    } 

    /**
     * ブログ投稿画面を表示する
     * @return view
     */

    public function exeStore(BlogRequest $request)
    {
        $inputs = $request->all();

        \DB::beginTransaction();
        try {
            \DB::commit();
            Blog::create($inputs);
        } catch (\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
       
        \Session::flash('err_msg','ブログを登録しました。');
        return redirect(route('blogs'));
    } 

    /**
     * 編集画面表示
     * @return view
     * @param int $id
     */
    public function showEdit($id)
    {
        $blog = Blog::find($id);

        if(is_null($blog)){
          \Session::flash('err_msg','データがありません。');
          return redirect(route('blogs'));
        }
        return view('blog.edit',['blog'=>$blog]);
    }

    public function exeUpdate(BlogRequest $request)
    {
       $inputs = $request->all();

       \DB::beginTransaction();
       try {
          $blog = $request->find($inputs['id']);
          $blog = fill([
              'title' => $title,
              'content' => $content
          ]);
          $blog->save();
          \DB::commit();
       } catch (\Throwable $th) {
           \DB::rollback();
           abort(500);
       }
       
       \Session::flash('err_msg','更新しました。');
       return redirect(route('blogs'));
    }

    /**
     * 削除
     * @return view
     * @param int $id
     */
    public function exeDelete($id)
    {
        if(empty($id)){
            \Session::flash('err_msg','データがありません。');
            return redirect(route('blogs'));
        }

        try {
            Blog::destroy($id);
        } catch (\Throwable $e) {
            about(500);
        }
      
      \Session::flash('err_msg','削除しました。');  
      return redirect(route('blogs'));
    }

}
