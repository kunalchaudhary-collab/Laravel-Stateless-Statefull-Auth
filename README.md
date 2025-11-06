### ✅ ✅ STATELESS vs STATEFUL (Simple Explanation)
##### ✅ STATELESS
```
➡ No session
➡ No cookies
➡ No server memory
➡ Every request must send API token
```
##### Used for:

- Mobile apps

- Postman

- React / Vue SPA using token mode

- External integrations

##### Anything using Bearer Token

- Example Request:
```bash
Authorization: Bearer <token>
```
### Advantages
```
✅ Fast
✅ Scalable
✅ No session storage
✅ Stateless APIs (like Laravel API routes)
```

##### ✅ STATEFUL
```
➡ Uses session
➡ Uses cookies
➡ Server remembers the user
➡ Browser-based login
```

### Used for:

```
Normal web login (Laravel Breeze, Jetstream, Fortify)

SPA that uses session cookies

Sanctum SPA auth
```

- Example Flow:

- Login

- Server sets session cookie

- Browser automatically sends cookie

- Server knows who user is

```
✅ Best for web apps with login forms
✅ Automatically sends cookie
✅ No need to include token manually
```

### ✅ How Sanctum Uses Stateful vs Stateless
```
Mode	For Who?	How It Authenticates
STATEFUL Sanctum	Web, SPA	Session cookie
STATELESS Sanctum	Mobile apps, APIs, Postman	Bearer token
```


## ✅ 1. Sanctum setup for Stateless API

```bash
Install Sanctum:
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```
## ✅ 2. Add HasApiTokens to User model

```php

app/Models/User.php
php
Copy code
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
}
```
## ✅ 3. Stateless Sanctum Authentication (Login / Register)
- 📌 AuthController
```
php artisan make:controller Api/AuthController
```

```php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ✅ Register
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'message' => 'Registered successfully',
            'user' => $user,
            'token' => $token
        ]);
    }


    // ✅ Login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'message' => 'Logged in',
            'user' => $user,
            'token' => $token
        ]);
    }


    // ✅ Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
```

### ✅ 5. API Routes (Stateless Mode)

- Open:
```
routes/api.php
```

- Add:
```
use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});
```

### ✅  6. Test in Postman / Mobile App
##### ✅ Login or Register → Get Token

```
Response example:

{
    "token": "12|qwertyuiopasdfghjk123456789"
}
```
##### ✅ 7. Use Token (Stateless Auth)
```
Add this header:

Authorization: Bearer 12|qwertyuiopasdfghjk123456789
```

- Now call:

```
GET /api/user


✅ Works
❌ No cookies
❌ No session
✅ 100% Stateless
```



