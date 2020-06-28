<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Exchange</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/fontawesome.min.css" integrity="sha256-80fAXabaQMIQSB79XD5pFt2eVZuI12D3yF6/FAkbO8E=" crossorigin="anonymous" />
        

 <script>
           
            (function () {
                window.Laravel = {
                    csrfToken: '{{ csrf_token() }}'
                };
            })();
          
        </script>
        
      
    </head>
    <body>
         <div id="app">
                <mainapp></mainapp>
           
         </div>
    </body>
    <script src="{{mix('/js/app.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/js/all.min.js" integrity="sha256-HkXXtFRaflZ7gjmpjGQBENGnq8NIno4SDNq/3DbkMgo=" crossorigin="anonymous"></script>

</html>
