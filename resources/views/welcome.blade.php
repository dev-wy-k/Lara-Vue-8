<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.6.0/css/all.min.css">
        <link rel="stylesheet" href="/css/app.css">

        <link rel="icon" href="{{ asset('favicon.ico') }}">
        <title>Laravel Vue</title>
        
    </head>
    <body class="">
        
    <div id="app">
        <product-component></product-component>
        <vue-progress-bar></vue-progress-bar>
    </div>

    </body>

    
    <script src="/js/app.js"></script>
</html>


