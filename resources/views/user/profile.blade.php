@extends('layouts.app')

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
}
</style>
<div id="about-me-feature-main">
    <div class="ls-sc-grid_12">
        <div class="ls-sc-grid_6 about-me-element">
            <div id="page-title"><h1>Profile</h1></div><!-- close #page-title -->
                        
            <div id="content-container-pro">
                <div class="wpcf7">
                    <form class="progression-contact" id="CommentForm" method="post" action="{{url('/account')}}" novalidate="novalidate">
                        {{ csrf_field() }}
                        <fieldset>
                            <div>
                                <p><input class="textInput disabled" value="{{ $user->username }}" disabled></p>
                            </div>
                            <div>
                                <p><input id="ContactName" name="name" class="textInput required" placeholder="Name" aria-required="true" value="{{ $user->name }}"></p>
                            </div>
                            <div>
                                <p><input class="textInput disabled email" value="{{ $user->email }}" disabled></p>
                            </div>
                            <div>
                                <p><input id="ContactPhone" name="phone" class="textInput" value="" placeholder="Phone" value="{{ $user->phone }}"></p>
                            </div>
                            <div>
                                <p><input name="sex" class="textInput" value="" placeholder="Sex" value="{{ $user->sex }}"></p>
                            </div>
                            <div>
                                <p><button type="submit" class="progression-contact-submit wpcf7-submit"><span>Update</span></button></p>
                            </div>
                            <div>
                                Change Password (Optional)
                            </div>
                            <div>
                                <p><input name="old_password" type="password" placeholder="Old password"></p>
                            </div>
                            <div>
                                <p><input name="password" type="password" placeholder="New password"></p>
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div>
                                <p><input name="password-confirm" type="password" placeholder="Confirm password"></p>
                            </div>
                        </fieldset>
                    </form> 
                </div>
                <div class="clearfix"></div>
            </div>          
        </div>
        <div class="ls-sc-grid_6 about-me-element">
            <img src="{{ $user->getAvatar() }}" style="max-width: 100%; height: auto;">
        </div>
    </div>
</div><!-- close #about-me-feature-main -->
@endsection
