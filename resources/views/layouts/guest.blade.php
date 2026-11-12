<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CloudCakes</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --cc-tuna: #3B244B;
            --cc-honey-flower: #4F2E69;
            --cc-dusty-purple: #7E5F96;
            --cc-ghost: #D3C2E1;
            --cc-ghost-white: #FBF7FF;
        }

        body {
            background-color: var(--cc-ghost-white);
            color: var(--cc-tuna);
        }

        .btn-primary {
            background-color: var(--cc-dusty-purple);
            border-color: var(--cc-dusty-purple);
            color: #ffffff;
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--cc-honey-flower);
            border-color: var(--cc-honey-flower);
        }

        .card {
            border-color: var(--cc-ghost);
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>