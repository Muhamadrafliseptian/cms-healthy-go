<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            background-color: #f8f9fa;
        }

        .login-container {
            max-width: 900px;
        }

        .login-image {
            background: url('{{ asset('template/assets/img/login.png') }}') no-repeat center center;
            background-size: contain;
            border-top-left-radius: 0.5rem;
            border-bottom-left-radius: 0.5rem;
        }

        @media (max-width: 768px) {
            .login-image {
                display: none;
            }
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center">

    <div class=" login-container  border-0 d-flex flex-md-row w-100">
        <div class="col-md-6 login-image"></div>

        <div class="col-md-6 p-5">
            <h4 class="mb-4 text-start">Login</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" class="text-start" action="{{ url('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-success btn-sm w-100">Login</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
