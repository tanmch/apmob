<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function index()
    {
        $database = app('firebase.database');
        $posts    = $database->getReference('posts')->getValue();

        return view('posts.index', ['posts' => $posts]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
        ]);

        $database = app('firebase.database');
        $database->getReference('posts')->push([
            'title'      => $request->title,
            'content'    => $request->content,
            'author'     => Session::get('user.email'),
            'created_at' => now()->toDateTimeString(),
        ]);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Postingan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $database = app('firebase.database');
        $post     = $database->getReference("posts/{$id}")->getValue();

        if (! $post) {
            return redirect()->route('posts.index')
                             ->with('error', 'Postingan tidak ditemukan.');
        }

        return view('posts.edit', ['id' => $id, 'post' => $post]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
        ]);

        $database = app('firebase.database');
        $database->getReference("posts/{$id}")->update([
            'title'   => $request->title,
            'content' => $request->content,
        ]);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Postingan berhasil diperbarui.');
    }

    // ← tambahkan method destroy ini
    public function destroy($id)
    {
        $database = app('firebase.database');
        $database->getReference("posts/{$id}")->remove();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Postingan berhasil dihapus.');
    }
}
