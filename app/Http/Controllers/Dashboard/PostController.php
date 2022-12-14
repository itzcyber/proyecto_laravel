<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use App\Models\Post;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\PutRequest;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts = Post::paginate(6);
        return view('dashboard.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('id', 'title');
        $post = new Post();

        //User::get()->where();
        return view('dashboard.post.create', compact('categories', 'post'))->with(['button' => "Crear Post"]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        //dd($request->all());

        $validated = $request->validate(StoreRequest::myRules());
        //$validated = Validator::make($request->all(), StoreRequest::myRules());

        //dd($validated->errors());

        //$data = $request->validated();
        //$data['slug'] = Str::slug($data['title']);


        //$data = array_merge($request->all(), ['image' => '']);

        Post::create($request->validated());

        
        //dd($data);

        return to_route("post.index")->with('status',"Registro creado.");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view("dashboard.post.show", compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */

    public function edit(Post $post)
    {
        $categories = Category::pluck('id', 'title');
        return view('dashboard.post.edit', compact(['categories','post']))->with(['button' => "Editar Post"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PutRequest $request, Post $post)
    {

        $validated = $request->validate(PutRequest::myRules($post));

        $data = $request->validated();

        //dd($request->validated()["image"]);
        if ( isset($data["image"])) {
            //$request->validated()["image"]->move(public_path("image"), $filename);  
            
            $filename = time().'.'.$data["image"]->getClientOriginalExtension();
            $request->file("image")->move(public_path("image"), $filename); 
            $post->image = $filename;
            
        }
        //dd($request->all());

        //$post->update($request->validated());

        $post->update([
            "title" => $data["title"],
            "content" => $data["content"],
            "category_id" => $data["category_id"],
            "description" => $data["description"],
            "posted" => $data["posted"],
        ]);

        /* $post->image = $filename;
        $post->save(); */

        //$request->session()->flash('status',"Registro Actualizado.");
        return to_route("post.index")->with('status',"Registro Actualizado.");
        
    }

    /**
     * Remove the specified resource from storage.  
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return to_route("post.index")->with('status',"Registro Eliminado. ");
    }
}
