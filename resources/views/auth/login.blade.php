@extends('layout.app')

@section('content')

<style>
    .form-box {
        max-width: 350px;
        margin: 40px auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
    }

    .form-box h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        margin-bottom: 5px;
        color: #444;
        font-weight: bold;
    }

    .form-group input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        outline: none;
        transition: 0.2s;
    }

    .form-group input:focus {
        border-color: #556b7a;
        box-shadow: 0 0 5px rgba(85,107,122,0.3);
    }

    .error-text {
        color: red;
        font-size: 13px;
        margin-top: 3px;
    }

    .submit-btn {
        width: 100%;
        padding: 10px;
        background: #556b7a;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: 0.2s;
    }

    .submit-btn:hover {
        background: #445765;
    }

    .signup-text {
        text-align: center;
        margin-top: 10px;
        font-size: 14px;
    }
</style>

<div class="form-box">
    <h2>Login</h2>

    <form action="{{ route('login.now') }}" method="post">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" placeholder="Enter your email">
            @error('email')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password">
            @error('password')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="submit-btn">Login</button>

        <div class="signup-text">
            Don’t have an account? 
            <a href="{{ route('register') }}">Signup</a>
        </div>
    </form>
</div>

@endsection
