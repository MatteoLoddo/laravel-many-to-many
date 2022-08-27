<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use illuminate\Support\Str;



class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    private function findBySlug($slug)
    {
        $post = Post::where("slug", $slug)->first();

        if (!$post) {
            abort(404);
        }

        return $post;
    }


    private function generateSlug($text)
    {
        $toReturn = null;
        $counter = 0;

        do {
            $slug = Str::slug($text);

            if ($counter > 0) {
                $slug .= "-" . $counter;
            }

            $slug_esiste = Post::where("slug", $slug)->first();

            if ($slug_esiste) {
                $counter++;
            } else {
                $toReturn = $slug;
            }
        } while ($slug_esiste);

        return $toReturn;
    }







    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        $tags = Tag::all();

        return view('admin.posts.index', compact('posts' , 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        return view('admin.posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // validiamo i dati ricevuti dal form nel create
        $validated = $request->validate([
            'title' => 'required|min:5',
            'content' => 'required|min:10',
            "tags" => "nullable|exists:tags,id",

        ]);

        $post = new Post();
        $post->fill($validated);
        $post->user_id = Auth::user()->id;

        $post->slug = $this->generateSlug($post->title);

        
        $post->save();


        if (key_exists("tags", $validated)) {
            $post->tags()->attach($validated["tags"]);
        }


        return redirect()->route('admin.posts.show', $post->slug);
    }

    /**
     * Display the specified resource       numhjybi7 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = $this->findBySlug($slug);

        return view('admin.posts.show', compact("post"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $slug)
    {
        $post = $this->findBySlug($slug);
        $tags = Tag::all();

        return view('admin.posts.edit', compact('post', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {

        $validated = $request->validate([
            'title' => 'required|min:5',
            'content' => 'required|min:10',
            'tags' => 'nullable|exists:tags,id',
        ]);

        $post = $this->findBySlug($slug);

        if ($validated['title'] !== $post->title) {
            $post->slug = $this->generateSlug($validated['title']);
        }
        if (key_exists('tags', $validated)) {

            $post->tags()->detach();
            $post->tags()->attach($validated['tags']);
        }else{
            $post->tags()->detach();

        }

        $post->update($validated);

        return redirect()->route('admin.posts.show', $post->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $post = $this->findBySlug($slug);
        $post->delete();

        return redirect()->route('admin.posts.index');
    }
}
