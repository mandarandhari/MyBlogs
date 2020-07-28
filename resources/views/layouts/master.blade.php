
<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Clean Blog</title>

    <meta name="description" content="A Blog Theme by Start Bootstrap">

    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="/css/app.css">

    <link rel="stylesheet" href="/css/main.css">
    <script>
        var app_url = "{{ env('APP_URL') }}";
        var app_admin_url = "{{ env('APP_ADMIN_URL') }}";
    </script>
    <!-- <link rel="canonical" href="https://startbootstrap.github.io/startbootstrap-clean-blog-jekyll/"> -->
    <!-- <link rel="alternate" type="application/rss+xml" title="Clean Blog" href="/startbootstrap-clean-blog-jekyll/feed.xml"> -->

</head>


<body>
    <div id="app">
        
    </div>

    <script src="/js/app.js"></script>
    
    <script src="/js/clean-blog.min.js"></script>

    <script src="/js/scripts.js"></script>


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-XXXXXXXXX-X"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-XXXXXXXXX-X');
    </script>



</body>

</html>
