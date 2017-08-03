<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>error 404 for Website Template | Home :: w3layouts</title>

<style type="text/css">
body{
    font-family: 'Courgette', cursive;
}
body{
    background:#f3f3e1;
}   
.wrap{
    margin:0 auto;
    width:1000px;
}
.logo{
    margin-top:50px;
}   
.logo h1{
    font-size:200px;
    color:#8F8E8C;
    text-align:center;
    margin-bottom:1px;
    text-shadow:1px 1px 6px #fff;
}   
.logo p{
    color:rgb(228, 146, 162);
    font-size:20px;
    margin-top:1px;
    text-align:center;
}   
.logo p span{
    color:lightgreen;
}   
.sub a{
    color:white;
    background:#8F8E8C;
    text-decoration:none;
    padding:7px 120px;
    font-size:13px;
    font-family: arial, serif;
    font-weight:bold;
    -webkit-border-radius:3em;
    -moz-border-radius:.1em;
    -border-radius:.1em;
}   
.footer{
    color:#8F8E8C;
    position:absolute;
    right:10px;
    bottom:10px;
}   
.footer a{
    color:rgb(228, 146, 162);
}   
</style>
</head>


<body data-gr-c-s-loaded="true">

<div class="wrap content">
    <div class="logo">
        <div class="title">Something went wrong.</div>
            @unless(empty($sentryID))
            <!-- Sentry JS SDK 2.1.+ required -->
            <script src="https://cdn.ravenjs.com/3.3.0/raven.min.js"></script>
            <script>
                Raven.showReportDialog({
                    eventId: '{{ $sentryID }}',
                    // use the public DSN (dont include your secret!)
                    dsn: 'https://8be41193a2504ad9827df89b8de17c95@sentry.io/64336'
                });
            </script>
    @endunless
    </div>
</div>
    
</body>
</html>