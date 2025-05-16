<!DOCTYPE html>
<html>
<head>
  <title>Daftar Postingan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
  <div class="max-w-4xl mx-auto mt-10">

    <h1 class="text-3xl font-bold mb-4">Daftar Postingan</h1>

    @if(session('success'))
      <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    <div class="mb-6 space-x-2">
      <a href="{{ route('posts.create') }}"
         class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        + Tambah Postingan
      </a>
      <a href="{{ route('dashboard') }}"
         class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
        ← Kembali ke Dashboard
      </a>
    </div>

    @if($posts)
      @foreach($posts as $key => $post)
        <div class="bg-white p-4 shadow rounded mb-4">
          <h2 class="text-xl font-semibold">{{ $post['title'] }}</h2>
          <p class="text-gray-600 text-sm mb-2">
            by {{ $post['author'] }} | {{ $post['created_at'] }}
          </p>
          <p>{{ $post['content'] }}</p>
          <div class="mt-4 flex gap-3">
            <a href="{{ route('posts.edit', $key) }}"
               class="text-yellow-600 hover:underline text-sm">
              Edit
            </a>
            <form method="POST" action="{{ route('posts.destroy', $key) }}"
                  onsubmit="return confirm('Yakin ingin menghapus postingan ini?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline text-sm">
                Hapus
              </button>
            </form>
          </div>
        </div>
      @endforeach
    @else
      <p>Belum ada postingan.</p>
    @endif

    @extends('layouts.app')

  @section('content')
  <h2>Manajemen Pengguna</h2>

  <table border="1" cellpadding="8">
      <thead>
          <tr>
              <th>Nama</th>
              <th>Email</th>
              <th>Role</th>
              <th>Aksi</th>
          </tr>
      </thead>
      <tbody>
          @foreach($users as $uid => $user)
              <tr>
                  <td>{{ $user['name'] ?? '-' }}</td>
                  <td>{{ $user['email'] ?? '-' }}</td>
                  <td>{{ $user['role'] ?? '-' }}</td>
                  <td>
                      <a href="{{ route('admin.users.edit', $uid) }}">Edit</a> |
                      <form action="{{ route('admin.users.delete', $uid) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</button>
                      </form>
                  </td>
              </tr>
          @endforeach
      </tbody>
  </table>
  @endsection
  </div>
</body>
</html>
