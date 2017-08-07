<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>New Style</title>

        <link rel="stylesheet" href="{{ asset('css/demo.css') }}">
        <link rel="stylesheet" href="{{ asset('css/form-labels-on-top.css') }}">
    </head>
    <body data-gr-c-s-loaded="true">
        <div class="main-content">

            <!-- You only need this form and the form-labels-on-top.css -->

            <form class="form-labels-on-top" method="post" action="{{ url('/styles/excel_build') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-title-row">
                    <h1>New</h1>
                </div>

                <div class="form-row">
                    <label>
                        <span>Add Excel File</span>
                        <input type="file" name="file">
                    </label>
                </div>

                <div class="form-row">
                    <button type="submit">Submit Form</button>
                </div>

            </form>

        </div>
    </body>
</html>
