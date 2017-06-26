<?php

namespace App\Http\Controllers;

use App\Post;
use Image;
use Auth;
use URL;
use File;
use Validator;
use Storage;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guest()) {
            session()->flash('auth', 'Чтобы получить доступ к админ-панели, нужно войти как администратор');
            return redirect()->route('login');
        } elseif (Auth::user()->hasRole('admin')) {
            $post = Post::orderby('created_at', 'desc')->paginate(10);

            for ($i = 0; $i < count($post); $i++) {
                $post[$i]->content = strip_tags($post[$i]->content);
                $post[$i]->content = substr($post[$i]->content, 0, 200);
                $post[$i]->content = rtrim($post[$i]->content, "!,.-");
            }

            

            return view('admin.pages.admin')->with('post', $post);
        } else {
            session()->flash('auth', 'Чтобы получить доступ к админ-панели, нужно войти как администратор');
            return redirect('/');
        }
    }
    

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guest()) {
            return redirect()->route('login');
        } elseif (Auth::user()->hasRole('admin')) {
            return view('admin.pages.create');
        } else {
            return redirect('/');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'image' => 'mimes:jpeg,bmp,png'
            ]);

        if ($validator->fails()) {
            $title = $request->title;
            $content = $request->content;
            $image = strval($request->image);
            $errors = $validator->errors();
            $imageWith = false;


            $with = [
            'title' => $title,
            'content' => $content,
            'errors' => $errors,
            'image' => $imageWith
            ];

            return redirect()->route('admin-panel.create')->withInput()->with($with);
        }


        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();

        $imgPath = $request->image;
        if ($imgPath != null) {
            $post->image = $imgPath;
            $pathSaveImg = public_path("/img/posts/" . $post->id . ".png");
            $img = Image::make($imgPath)->save($pathSaveImg);
            $post->save();
        }

        $request->session()->flash('success', 'Новость успешно добавлена');
        $returnArg = ['id' => $post->id];

        return redirect()->route('admin-panel.index')->with($returnArg);
    }







    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        if ($post->status == 0) {
            $post->status = 1;
            $post->save();
            session()->flash('success', 'Новость успешно опубликована');
        } else {
            $post->status = 0;
            $post->save();
            session()->flash('success', 'Новость успешно снята с публикации');
        }

        return redirect()->route('admin-panel.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        return view('admin.pages.edit')->withPost($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);


        $post->title = $request->title;
        $post->content = $request->content;

        if ($request->delete_image) {
            $post->image = ' ';
            $pathdelete =  public_path("/img/posts/" . $id . ".png");
            $file = File::delete($pathdelete);
        }

        if ($request->image) {
            $imgPath = $request->image;
            $post->image = $request->image;
            $pathSaveImg = public_path("/img/posts/" . $id . ".png");
            $img = Image::make($imgPath)->save($pathSaveImg);
        }

        $post->save();
        $request->session()->flash('success', 'Новость успешно отредактирована!');


        return redirect()->route('admin-panel.index', $post->id);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if (!is_null($post)) {
            $pathdelete =  public_path("/img/posts/" . $id . ".png");
            $file = File::delete($pathdelete);
            $post->delete();
            session()->flash('delete', 'Новость успешно удалена');
        }



        return redirect()->route('admin-panel.index');
    }
}
