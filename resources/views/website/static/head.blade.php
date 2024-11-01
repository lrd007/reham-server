<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if(isset($title))
            {{ $title  }} -
        @else
            {{ __('words.Homepage') }} -
        @endif
         {{ env('app_name') }}</title>

    <link rel="apple-touch-icon" href="{{ asset('assets/dexter/favicon_io/logo192.png.') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/dexter/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/dexter/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/dexter/favicon_io/favicon-16x16.png') }}">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/dexter/css/bootstrap.rtl.css') }}"/>
    <!-- fontawsome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- style -->
    <link rel="stylesheet" href="{{ asset('assets/dexter/css/style.css') }}"/>
</head>
<body>
