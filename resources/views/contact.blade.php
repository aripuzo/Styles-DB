@extends('layouts.app')

@section('content')
<div id="main">
    <div class="page-container">
        <div id="page-title"><h1>Contact</h1></div><!-- close #page-title -->
                        
        <div id="content-container-pro">
            <p>Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided.</p>

            <div class="wpcf7">
                <form class="progression-contact" id="CommentForm" method="post" action="#" novalidate="novalidate">
                    <fieldset>
                        <div>
                            <p><input id="ContactName" name="ContactName" class="textInput required" placeholder="Name" aria-required="true"></p>
                        </div>
                        <div>
                            <p><input id="ContactEmail" name="ContactEmail" class="textInput required email" placeholder="E-mail" aria-required="true"></p>
                        </div>
                        <div>
                            <p><input id="ContactPhone" name="ContactPhone" class="textInput digits" value="" placeholder="Phone"></p>
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
