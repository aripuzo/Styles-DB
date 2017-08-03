@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/jquery.tagit.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/tagit.ui-zendesk.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('scripts')
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script> -->
    <script src="{{asset('js/tag-it.js')}}" type="text/javascript" charset="utf-8"></script>
    <script>
        jQuery(function(){
            var myTags = jQuery('#myTags');

            var addEvent = function(text) {
                jQuery('#events_container').append(text + '<br>');
            };

            myTags.tagit({
                readOnly: false,
                singleField: true,
            });
        });
    </script>
@endsection

@section('content')
<div id="main">
    <div class="page-container">
        <div id="page-title"><h1>Send Style</h1></div><!-- close #page-title -->
                        
        <div id="content-container-pro">
            <p>
            Please upload your pictures to help someone choose a style for their next occassion.
            </p>
            <!-- <p>Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided.</p> -->

            <div class="wpcf7">
                <form class="progression-contact" id="CommentForm" method="post" action="#" novalidate="novalidate">
                    <fieldset>
                        <div>
                            <p><input id="ContactName" name="designer" class="textInput" placeholder="Name of Designer/Tailor (optional)"></p>
                        </div>
                        <div>
                            <p><input id="img" name="img" class="fileInput" type="file"></p>
                        </div>
                        <div>
                            <p>
                            <input name="tags" id="mySingleField" disabled="true" type="hidden">
                            <ul id="myTags"></ul>
                            </p>
                        </div>
                        <div>
                            <p><textarea id="ContactComment" name="ContactComment" class="textInput required" rows="10" cols="4" placeholder=" Your Message" aria-required="true"></textarea></p>
                        </div>
                        <div>
                            <p><button type="submit" class="progression-contact-submit wpcf7-submit"><span>Send</span></button></p>
                        </div>
                    </fieldset>
                </form> 
            </div>
            <div class="clearfix"></div>
        </div>          
    </div><!-- close .page-container -->
</div>
@endsection
