<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
    <style>
        body{
            background-color: #ebf0f4;
        }
        /* .bg-light {
            background-color: #eae9e9 !important;
        } */
    </style>
</head>
<body>
<div id="app">
</div>
<script>
// window.Laravel = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
// console.log(window.Laravel);
// window.Laravel = {csrfToken: '{{ csrf_token() }}'}
// console.log(window.Laravel);
</script>
<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>
</html>