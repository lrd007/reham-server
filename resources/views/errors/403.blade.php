@if(auth())
    @include('errors.403-alt')
@else

    <html lang="en"><head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Forbidden</title>
            <style>
                body p{
                    position: absolute;
                    top: 48%;
                    left: 42.5%;
                    font-size: 22px;
                    color: #a7a7a7;
                    font-family: Nunito, sans-serif;
                }
            </style>
        </head>
        <body class="antialiased">
            <p><b>403</b> | This action is unauthorized.</p>
        </body>
    </html>

@endif