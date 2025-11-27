# JurnalApp — Laravel

> Kode penuh (skeleton + contoh implementasi) untuk aplikasi Jurnal menggunakan **Laravel**.
> Dokumen ini berisi: README lengkap, struktur project, contoh route, controller, model, migration, resource views, dan contoh konfigurasi .env.

---

## 📘 README.md (Lengkap)

````markdown
# JurnalApp (Laravel)

Aplikasi sederhana untuk mencatat jurnal (harian / catatan). Dibangun menggunakan Laravel 10 (atau terbaru) sebagai contoh starter project.

## Fitur
- Autentikasi (register / login)
- CRUD Jurnal (create, read, update, delete)
- API endpoints (JSON)
- Views Blade sederhana untuk web
- Validasi dan migration

## Teknologi
- PHP >= 8.1
- Laravel 10+
- MySQL / MariaDB
- Composer

## Struktur Singkat
- `app/Models/Journal.php` — Eloquent model
- `app/Http/Controllers/AuthController.php` — Login/Register
- `app/Http/Controllers/JournalController.php` — CRUD jurnal
- `database/migrations/*_create_journals_table.php` — migration
- `resources/views/*` — Blade views
- `routes/web.php` dan `routes/api.php`

## Instalasi
1. Clone repo
```bash
git clone https://github.com/username/jurnalapp-laravel.git
cd jurnalapp-laravel
````

2. Install dependencies

```bash
composer install
npm install && npm run dev
```

3. Copy env

```bash
cp .env.example .env
php artisan key:generate
```

4. Atur database di `.env` lalu migrasi

```bash
php artisan migrate
php artisan db:seed
```

5. Jalankan server

```bash
php artisan serve
```

## API endpoints (contoh)

* `POST /api/register` — register
* `POST /api/login` — login
* `GET /api/journals` — list jurnal (auth)
* `POST /api/journals` — buat jurnal (auth)

## Catatan

Sesuaikan file env, queue, dan konfigurasi storage jika memakai upload.

```
```

---

## 📁 Struktur Project (Contoh)

```
app/
  Models/
    Journal.php
  Http/
    Controllers/
      AuthController.php
      JournalController.php
config/
database/
  migrations/
  seeders/
resources/
  views/
    layouts/app.blade.php
    journals/index.blade.php
    journals/create.blade.php
routes/
  web.php
  api.php
.env.example
README.md
```

---

## 🔨 File — Contoh Kode Utama

> **1) routes/web.php**

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JournalController;

Route::get('/', function () {
    return redirect()->route('journals.index');
});

Route::middleware('auth')->group(function () {
    Route::resource('journals', JournalController::class);
});

require __DIR__.'/auth.php'; // jika menggunakan Laravel Breeze / Jetstream
```

---

> **2) routes/api.php**

```php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JournalController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('journals', JournalController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});
```

---

> **3) app/Models/Journal.php**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'is_private'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

---

> **4) database/migrations/2025_01_01_000000_create_journals_table.php**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->boolean('is_private')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('journals');
    }
};
```

---

> **5) app/Http/Controllers/AuthController.php**

```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // jika pakai Sanctum
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
```

---

> **6) app/Http/Controllers/JournalController.php**

```php
<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $journals = Journal::where('user_id', $request->user()->id)->latest()->paginate(10);
            return response()->json($journals);
        }

        $journals = Journal::where('user_id', Auth::id())->latest()->paginate(10);
        return view('journals.index', compact('journals'));
    }

    public function create()
    {
        return view('journals.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_private' => 'sometimes|boolean'
        ]);

        $data['user_id'] = Auth::id();
        $data['is_private'] = $request->has('is_private');

        $journal = Journal::create($data);

        if ($request->wantsJson()) return response()->json($journal, 201);

        return redirect()->route('journals.index')->with('success', 'Jurnal dibuat');
    }

    public function show(Journal $journal)
    {
        $this->authorize('view', $journal);
        return view('journals.show', compact('journal'));
    }

    public function edit(Journal $journal)
    {
        $this->authorize('update', $journal);
        return view('journals.edit', compact('journal'));
    }

    public function update(Request $request, Journal $journal)
    {
        $this->authorize('update', $journal);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_private' => 'sometimes|boolean'
        ]);

        $data['is_private'] = $request->has('is_private');

        $journal->update($data);

        if ($request->wantsJson()) return response()->json($journal);

        return redirect()->route('journals.index')->with('success', 'Jurnal diperbarui');
    }

    public function destroy(Journal $journal)
    {
        $this->authorize('delete', $journal);
        $journal->delete();
        return redirect()->route('journals.index')->with('success', 'Jurnal dihapus');
    }
}
```

---

> **7) resources/views/layouts/app.blade.php**

```blade
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>JurnalApp</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="{{ route('journals.index') }}">JurnalApp</a>
    <div>
      @auth
        <span class="me-2">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">@csrf<button class="btn btn-sm btn-outline-secondary">Logout</button></form>
      @else
        <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Login</a>
      @endauth
    </div>
  </div>
</nav>

<div class="container py-4">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @yield('content')
</div>

</body>
</html>
```

---

> **8) resources/views/journals/index.blade.php**

```blade
@extends('layouts.app')

@section('content')
  <div class="d-flex justify-content-between mb-3">
    <h1>Jurnals</h1>
    <a href="{{ route('journals.create') }}" class="btn btn-primary">Buat Jurnal</a>
  </div>

  @foreach($journals as $journal)
    <div class="card mb-2">
      <div class="card-body">
        <h5 class="card-title">{{ $journal->title }}</h5>
        <p class="card-text">{{ Str::limit($journal->content, 150) }}</p>
        <a href="{{ route('journals.edit', $journal) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
        <form action="{{ route('journals.destroy', $journal) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Hapus</button></form>
      </div>
    </div>
  @endforeach

  {{ $journals->links() }}
@endsection
```

---

> **9) resources/views/journals/create.blade.php**

```blade
@extends('layouts.app')

@section('content')
  <h1>Buat Jurnal</h1>
  <form action="{{ route('journals.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label class="form-label">Title</label>
      <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Content</label>
      <textarea name="content" rows="6" class="form-control" required></textarea>
    </div>
    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" name="is_private" id="is_private">
      <label class="form-check-label" for="is_private">Private</label>
    </div>
    <button class="btn btn-primary">Simpan</button>
  </form>
@endsection
```

---

> **10) .env.example (paling dasar)**

```
APP_NAME=JurnalApp
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jurnal_db
DB_USERNAME=root
DB_PASSWORD=

# Jika pakai sanctum
SANCTUM_STATEFUL_DOMAINS=localhost

```

---

## ✅ Tips & Langkah Selanjutnya

* Untuk autentikasi siap pakai, gunakan Laravel Breeze atau Jetstream (lebih cepat).
* Aktifkan Laravel Sanctum untuk API token-based auth.
* Tambahkan Policy (php artisan make:policy JournalPolicy) untuk authorisasi resource.
* Tambahkan request validation classes bila perlu untuk kebersihan kode.

---

Jika kamu mau, aku bisa:

* Menambahkan **Policy** untuk `Journal`.
* Menambahkan **Seeders** untuk data dummy.
* Menyediakan contoh instalasi dengan **Docker**.

Tandai opsi yang kamu mau dan aku tambahkan pada dokumen ini.
