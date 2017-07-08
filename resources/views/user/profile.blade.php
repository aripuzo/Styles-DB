@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
<div id="about-me-feature-main">
    <div id="about-me-content-bg" style="position: relative; z-index: 0; background: none;">
        <div class="about-me-content">
            <div id="page-title">
                <h1>About me</h1>
            </div><!-- close #page-title -->
            <h5>Far far away, behind the word mountains, far from the countries <strong>Vokalia and Consonantia</strong>, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</h5>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed bibendum rhoncus sem in fermentum. Fusce cursus facilisis nibh sit amet pellentesque. Vestibulum id arcu velit. Pellentesque congue aliquam est, sed convallis elit mattis ac. Donec ipsum neque, ullamcorper eu libero a, varius elementum dolor. Etiam quam mi, ultrices ut ipsum eget, semper elementum mauris.</p>
            <p>Cras sit amet risus in enim pellentesque suscipit. Pellentesque sit amet molestie tellus, vitae vehicula mi. Proin a vestibulum ex, sed laoreet velit. Vestibulum euismod mi pellentesque nisi pretium posuere eget sed eros. Donec aliquet nulla in posuere pharetra. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc feugiat lacus eu semper lacinia.</p>
            <a href="http://www.progression-studios.com/zyra/contact.html" class="ls-sc-button default" target="_self" title="" rel=""><span class="ls-sc-button-inner">Contact Jane<i class="ls-sc-button-icon-right fa fa-envelope"></i></span></a>
        </div><!-- close .about-me-content -->
        <div class="clearfix"></div>
        <div class="backstretch" style="left: 0px; top: 0px; overflow: hidden; margin: 0px; padding: 0px; height: 708px; width: 540px; z-index: -999998; position: absolute;"><img src="images/about-me-image1.jpg" style="position: absolute; margin: 0px; padding: 0px; border: none; width: 894.787px; height: 708px; max-width: none; z-index: -999999; left: -177.393px; top: 0px;">
        </div>
    </div><!-- close .about-me-content -->
</div><!-- close #about-me-feature-main -->
@endsection
