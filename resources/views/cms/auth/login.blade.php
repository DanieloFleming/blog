<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/assets/css/cms.css">
    <title></title>
    <style>
        .login-form {
            width: 300px;
            border: 1px solid #cecece;
            padding: 30px;
            margin: 0 auto;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
        .login-form.invalid {
            border-color:#ffbebe;
        }
        .login-form-btn {
            background-color:#cecece;
            position:relative;
            border: none;
            width: 100%;
            padding: 10px;
            transition:background-color 1s ease;
        }

        .login-form-btn:hover {
            cursor: pointer;
            background-color:#bdbdbd;
            transition:background-color 1s ease;
        }
    </style>
</head>
<body>
<?php $invalid =  (count($errors) > 0) ? 'invalid' : '' ;?>

<form class="login-form {{$invalid}}" method="post" action="/login">
    {{ csrf_field() }}
    <input type="text" name="username" placeholder="username" class="field-title" value="{{ old('username') }}"/>
    <input type="password" name="password" placeholder="password" class="field-title"/>
    <input type="submit" value="Login" class="login-form-btn"/>
</form>

<script>

</script>
</body>
</html>