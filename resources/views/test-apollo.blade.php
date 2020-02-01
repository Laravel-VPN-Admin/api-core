<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test Vue-Apollo</title>
</head>
<body>
    <div id="app">
        <div class="container">
            <div class="row justify-content-center">
                <paginator-groups/>
            </div>
            <div class="row justify-content-center">
                <mutator-groups/>
            </div>
            <div class="row justify-content-center">
                <example-component/>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js')  }}" ></script>
</body>
</html>

