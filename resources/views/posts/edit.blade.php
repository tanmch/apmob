<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Postingan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
  <div class="max-w-xl mx-auto mt-10">

    <h1 class="text-2xl font-bold mb-6">Edit Postingan</h1>

    @if(session('error'))
      <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
        {{ session('error') }}
      </div>
    @endif

    <form method="POST" action="{{ route('posts.update', $id) }}" class="bg-white p-6 rounded shadow">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label class="block font-medium">Judul</label>
        <input
          type="text"
          name="title"
          value="{{ old('title', $post['title']) }}"
          class="w-full border border-gray-300 rounded p-2"
          required
        >
      </div>

      <div class="mb-4">
        <label class="block font-medium">Konten</label>
        <textarea
          name="content"
          class="w-full border border-gray-300 rounded p-2 h-32"
          required
        >{{ old('content', $post['content']) }}</textarea>
      </div>

      <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
        Perbarui
      </button>
      <a href="{{ route('posts.index') }}" class="ml-4 text-blue-600 hover:underline">Kembali</a>
    </form>
    @extends('layouts.app')

@section('content')
<h2>Edit Role Pengguna</h2>

<form method="POST" action="{{ route('admin.users.update', $uid) }}">
    @csrf
    <p>Nama: <strong>{{ $user['name'] }}</strong></p>
    <p>Email: <strong>{{ $user['email'] }}</strong></p>

    <label for="role">Role:</label>
    <select name="role" id="role">
        <option value="admin" {{ $user['role'] === 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="user" {{ $user['role'] === 'user' ? 'selected' : '' }}>User</option>
    </select>

    <br><br>
    <button type="submit">Simpan</button>
</form>

<a href="{{ route('admin.users') }}">← Kembali</a>
@endsection
  </div>
</body>
</html>
