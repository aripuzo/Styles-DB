@extends('layouts.app')

@section('title', isset($title) ? $title : 'Page Title')
@section('description', isset($description) ? $description : 'Description')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/form-labels-on-top.css') }}">
@endsection

@section('content')
<style type="text/css">
    .ls-sc-grid_12 {
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        background-color: #ffffff;
    }
    @media screen and (max-width: 640px) {
        .ls-sc-grid_12 {
            display: block;
        }
    }
    .about-me-element {
        padding: 60px 15px 60px 15px;
    }
    .img {
       object-fit: cover;
       height: auto;
    }
    .form-labels-on-top {
        box-sizing: none;
        padding: 0px;
        box-shadow: none;
        font: bold 14px sans-serif;
        text-align: center;
        max-width: 100%
    }
}
</style>
<div id="about-me-feature-main">
    <div class="ls-sc-grid_12">
        <div class="ls-sc-grid_6 about-me-element wpcf7">
            <form class="form-labels-on-top" method="post" action="{{ route('make_item', $item->id) }}">
                {{ csrf_field() }}
                <div class="form-row">
                    <label>
                        <span>Type of service</span>
                        <select id="service" name="service" class="textInput required" aria-required="true">
                            <option value="1">Normal - 7 working days</option>
                            <option value="2">Express - 3 days (+₦3000)</option>
                            <option value="3">Magic - 24 hours (+₦5000)</option>
                        </select>
                    </label>
                </div>
                <div class="form-row">
                    <label>
                        <span>How do we get your measurement</span>
                        <select id="measurement" name="measurement" class="textInput required" aria-required="true">
                            <option value="1">We should come over (free)</option>
                            <option value="2">You'll send it</option>
                            <option value="3">I trust US/UK sizes</option>
                        </select>
                    </label>
                </div>
                <div class="form-row">
                    <label>
                        <span>How do we get your fabric</span>
                        <select id="fabric" name="fabric" class="textInput required" aria-required="true">
                            <option value="1">We should come get it (free)</option>
                            <option value="2">You'll bring/send it</option>
                            <option value="3">We should buy for you</option>
                        </select>
                    </label>
                </div>
                <div class="form-row">
                    <label>
                        <span>How do you want to get your stuff when we finish</span>
                        <select id="delivery" name="delivery" class="textInput required" aria-required="true">
                            <option value="1">We should deliver (+ ₦1000)</option>
                            <option value="2">You'll come pick it up</option>
                        </select>
                    </label>
                </div>
                <div class="form-row">
                    <label>
                        <span>Any other thing you want us to note</span>
                        <textarea name="note"></textarea>
                    </label>
                </div>
                @if(!Auth::check())
                <br><p>Please just fill email and password if you've registered else fill all to register</p>
                <div class="form-row">
                    <label>
                        <span>Email</span>
                        <input id="ContactEmail" name="email" class="textInput required email" aria-required="true">
                    </label>
                </div>
                <div class="form-row">
                    <label>
                        <span>Password</span>
                        <input id="ContactEmail" name="password" class="passwordInput required" aria-required="true" type="password">
                    </label>
                </div>
                <div class="form-row">
                    <label>
                        <span>Name</span>
                        <input type="text" name="name" id="ContactEmail" class="textInput required">
                    </label>
                </div>
                @endif
                <br><p>Ignore this section if we aren't coming over for anything</p>
                <div class="form-row">
                    <label>
                        <span>Street Address</span>
                        <input type="text" name="street">
                    </label>
                </div>
                <div class="form-row">
                    <label>
                        <span>Area</span>
                        <input type="text" name="area">
                    </label>
                </div>
                <div class="form-row">
                    <label>
                        <span>State</span>
                        <select name="state">
                            <option value="Lagos">Lagos</option>
                        </select>
                    </label>
                </div>

                <div class="form-row">
                    <p><button type="submit" class="progression-contact-submit wpcf7-submit"><span>Send</span></button></p>
                </div>
            </form>
        </div><!-- close .about-me-content -->
        <div class="ls-sc-grid_6 about-me-element">
            <h6>Clothes are made by <a href="http://oversabi.com.ng">oversabi stitches</a></h6>
            <img src="{{ $item->getImage() }}">
        </div>
    </div><!-- close .about-me-content -->
    @include('item.partials.related')
</div><!-- close #about-me-feature-main -->
@endsection
