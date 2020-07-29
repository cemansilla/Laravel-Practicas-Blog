<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests\UserFormRequest;
use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redis;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$posts = Post::all();
        $posts = Post::paginate(10);
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //public function store(Request $request)
    public function store(UserFormRequest $request) // Se inyecta la dependencia del form request
    {
        /*
        // Esto se puede usar, pero se resuelve con la funcionalidad form request de Laravel
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5|max:10',
            'content' => 'required|min:5|max:50'
        ]);

        if($validator->fails()){
            return redirect()->route('posts.create')
                ->withErrors($validator)    // Envia errores a la vista
                ->withInput();              // Envia valores ingresados a la vista
        }
        */

        $post = new Post();
    
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->user_id = $request->user()->id;

        $post->save();

        return redirect()->route('posts.show', ['post' => $post]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        /**
         * Contador de vistas con Redis
         * Módulo 12.5
         */
        $redis_post_key = 'post:views:'.$post->id; 
        $counter = 0;
        if(Redis::exists($redis_post_key)){
            Redis::incr($redis_post_key);
            $counter = Redis::get($redis_post_key);
        }else{
            Redis::set($redis_post_key, 0);
        }

        return view('post.show', compact("post", "counter"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, Post $post)
    {
        // Alternativa estándar de validación de permisos de acción
        $this->authorize('update', $post);

        $post->title = $request->input('title');
        $post->content = $request->input('content');

        $post->save();

        return redirect()
                ->route('posts.edit', ['post' => $post])
                ->with('message', 'Post actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        /*
        // Esta validación de permisos con gates, se trabajó luego con la política PostPolicy
        $user = Auth::user();

        if(Gate::forUser($user)->denies('delete-post', $post)){
            return redirect()->back();
        }
        */

        // Alternativa con políticas de validación de permisos de acción
        if(Auth::user()->cant('delete', $post)){
            return redirect()->route('posts.my')
                    ->with('message', 'Permisos insuficientes para eliminar este post.');
        }

        $post->delete();
        return redirect()->route('posts.index');
    }

    public function myPosts(Request $request)
    {
        //$posts = Auth::user()->posts;
        $posts = Post::where('user_id', Auth::user()->id)->paginate(10);

        return view('post.my', compact('posts'));
    }
}
