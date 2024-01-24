<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Antrian - Login</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            max-width: 400px;
            margin: auto;
            margin-top: 60px;
        }

        .login-card {
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="mt-5">Sistem Antrian</h1>
            <p class="mt-4 text-muted">Mohon log in terlebih dahulu.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="login-container">

                @if($errors->any())
                <div class="alert alert-danger" id="errorMessage">
                    @foreach($errors->all() as $e)
                        {{$e}} <br/>
                    @endforeach
                </div>
                @endif

                <div class="card login-card">
                    <div class="card-body">
                        <form action="{{ url('login') }}" method="post">
                            <div class="form-group">
                                <label for="username">Email</label>
                                <input oninvalid="InvalidMsg(this);" type="email" class="form-control" id="email" name="email" placeholder="Masukan email" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input oninvalid="InvalidMsg(this);" type="password" class="form-control" id="password" name="password" placeholder="Masukan password" required>
                            </div>
                            @csrf
                            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript">
    function InvalidMsg(textbox) {

        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (textbox.value === '') {
            textbox.setCustomValidity('Mohon isi terlebih dahulu');
        } else if (textbox.type == 'email' && !emailPattern.test(textbox.value)){
            textbox.setCustomValidity('Mohon isi dengan format email yang benar');
        } else {
            textbox.setCustomValidity('');
        }

        return true;
    }

</script>

</body>
</html>
