<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta-name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PMS</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        nav {
            background: #556b7a;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        nav a {
            color: #fff;
            font-weight: bold;
            text-decoration: none;
        }

        nav span {
            margin-left: auto;
            color: #ffeb3b;
            font-weight: bold;
        }

        /* Toast Style */
        .toast {
            position: fixed;
            right: 20px;
            top: 20px;
            min-width: 250px;
            background: #333;
            color: white;
            padding: 12px 18px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            opacity: 0;
            transform: translateX(120%);
            transition: 0.5s;
            z-index: 9999;
            font-size: 14px;
        }

        .toast.show {
            opacity: 1;
            transform: translateX(0);
        }

        .toast.success {
            background: #28a745;
        }

        .toast.error {
            background: #dc3545;
        }

        .content {
            padding: 20px;
        }
    </style>
</head>

<body>
    
    <nav>
        @auth
            <a href="{{route('dashboard')}}">Dashboard</a>
            <a href="{{route('blog.view')}}">Blog</a>
            <a href="{{route('logout')}}">Logout</a>
            <span>Welcome, {{ auth()->user()->name }}</span>
        @else
            <a href="{{route('login')}}">Login</a>
            <a href="{{route('register')}}">Register</a>
        @endauth
    </nav>


    <!-- ✅ Toast Notification -->
    @if(session('success'))
        <div id="toast" class="toast success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div id="toast" class="toast error">{{ session('error') }}</div>
    @endif


    <div class="content">
        @yield('content')
    </div>


    <script>
        // ✅ Show toast automatically
        window.onload = function () {
            let toast = document.getElementById('toast');
            if (toast) {
                toast.classList.add('show');

                // Auto hide after 3 seconds
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
            }
        };
    </script>

</body>
</html>
