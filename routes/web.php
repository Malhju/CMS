<?php

use App\Post;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/insert', function (){
    DB::insert("INSERT INTO posts(title, content, user_id) VALUES (?, ?, ?)", ["PHP avec Laravel", "Laravel est plutôt facile", 1]);
});

Route::get('/read', function (){
    for ($i = 0; $i<100; $i++) {
        $posts = DB::select("SELECT * FROM posts WHERE id = ?", [$i]);
        var_dump($posts);
    }
});

Route::get('/update', function (){
    DB::update("UPDATE posts SET title = ?, content = ? WHERE id = ?", ["Post mis à jour", "avec succès", 1]);
});

Route::get('/delete', function (){
    DB::delete("DELETE FROM posts WHERE id = ?", [1]);
});

/*
|--------------------------------------------------------------------------
| Eloquent ORM
|--------------------------------------------------------------------------
*/

Route::get('/basicinsert', function(){
    // On ajoute le namespace avant la classe post (ici 'new App/Post') OU on ajoute un 'use App\Post;' en haut du fichier
    $Post = new Post();
    $Post->title = "Créé avec Eloquent";
    $Post->content = "babblebabble";
    $Post->user_id = 1;
    $Post->save();
});

Route::get('/find', function(){
    //trouver un post spécifique
    $Post = Post::find(7);
    //return $Post->title;

    //trouver tous les posts
    $Posts = Post::all();
    return $Posts;
});

Route::get('/basicupdate', function (){
    $Post = Post::findOrFail(6);
    $Post->title = "MAJ via Eloquent";
    $Post->save();
});

Route::get('/findwhere', function(){
    $Post = Post::where('content', '=', "babblebabble")->take(2)->get();
    // Lorsque l'on fait un get sur un builder, on récupère une collection.
    return $Post;
});

Route::get('/findmore', function() {
    $Post = Post::where('content', '=', "babblebabble")->firstOrFail();
    return $Post;
});

Route::get('/create', function (){
    // On change le modèle dans le Post.php où l'on "protège" les variables
    $values = [
        'title' => 'créer via create',
        'content' => 'easy',
        'user_id' => 1
    ];
    Post::create($values);
});