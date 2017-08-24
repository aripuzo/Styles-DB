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
                readOnly: true,
                onTagClicked: function(evt, ui) {
                    addEvent('onTagClicked: ' + myTags.tagit('tagLabel', ui.tag));
                },
            });
        });
        function addReply(el, name) {
            //event.preventDefault();
            @if (Auth::check())
            var comment_id = el.id;
            var input = document.getElementById("reply_id");
            if(!input)
                var input = document.createElement("input");
            input.type = "hidden";
            input.value = comment_id;
            input.name = "comment_id";
            input.id = 'reply_id';
            document.getElementById("CommentForm").appendChild(input);
            document.getElementById("reply-to").innerHTML = 'Reply to '+name;
            @else
                alert('Please login or register to perform action');
            @endif
        }
    </script>
@endsection

@section('content')
<style type="text/css">
    .ls-sc-grid_12 {
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        background-color: #ffffff;
        margin-left: 0%;
        padding-left: 1%;
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
    header, hgroup, menu, nav, section { display: block; }
    ol, ul { list-style: none; }
    #cont { 
      display: block; 
      width: 100%; 
      background: #fff; 
      padding: 14px 20px; 
      -webkit-border-radius: 4px; 
      -moz-border-radius: 4px; 
      border-radius: 4px; 
      -webkit-box-shadow: 1px 1px 1px rgba(0,0,0,0.3);
      -moz-box-shadow: 1px 1px 1px rgba(0,0,0,0.3);
      box-shadow: 1px 1px 1px rgba(0,0,0,0.3);
    }
    /* comments area */
    #comments { display: block; }

    #comments .cmmnt, ul .cmmnt, ul ul .cmmnt { display: block; position: relative; padding-left: 65px; border-top: 1px solid #ddd; }

    #comments .cmmnt .avatar  { position: absolute; top: 8px; left: 0; }
    #comments .cmmnt .avatar img { 
      -webkit-border-radius: 3px; 
      -moz-border-radius: 3px; 
      border-radius: 3px; 
      -webkit-box-shadow: 1px 1px 2px rgba(0,0,0,0.44);
      -moz-box-shadow: 1px 1px 2px rgba(0,0,0,0.44);
      box-shadow: 1px 1px 2px rgba(0,0,0,0.44);
      -webkit-transition: all 0.4s linear;
      -moz-transition: all 0.4s linear;
      -ms-transition: all 0.4s linear;
      -o-transition: all 0.4s linear;
      transition: all 0.4s linear;
    }

    #comments .cmmnt .avatar a:hover img { opacity: 0.77; }

    #comments .cmmnt .cmmnt-content { padding: 0px 3px; padding-bottom: 12px; padding-top: 8px; }

    #comments .cmmnt .cmmnt-content header {display: block; margin-bottom: 8px; }
    #comments .cmmnt .cmmnt-content header .pubdate { color: #777; }

    #comments .cmmnt .replies { margin-bottom: 7px; }

    .reply a.comment-reply-link {
        font-size: 11px;
        position: absolute;
        padding: 6px 10px;
        right: 0px;
        margin-top: -15px;
        display: block;
        outline: none !important;
        text-decoration: none;
        transition-duration: 250ms;
        transition-property: color, background-color, opacity, border;
        transition-timing-function: ease-in-out;
    }
    .prog {
        text-align: right;
        margin-right: 0% !important;
        width: 65%;
        float: left;
        min-height: 2px;
    }
    ul.blog-single-social-sharing {
        list-style: none;
        margin: 0px;
        padding: 0px;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    ul.blog-single-social-sharing li.social-sharing-title {
        font-weight: 500;
        color: #b6b6b6;
    }
    ul.blog-single-social-sharing li {
        display: inline;
        margin: 0px;
        padding: 0px;
        text-align: -webkit-match-parent;
    }
    ul.blog-single-social-sharing li a {
        display: inline-block;
        margin-left: 5px;
        text-align: center;
        width: 38px;
        height: 38px;
        line-height: 38px;
        margin-bottom: 4px;
        font-size: 18px;
        border-radius: 30px;
        color: #14141d;
        border: 2px solid #ececed;
    }
    ul.blog-single-social-sharing li a:hover {
        color:#ffffff;
        background:#52535e;
        border-color:#52535e;
    }
    ul.blog-single-social-sharing li a.facebook-share:hover {
        background:#3b5998;
        border-color:#3b5998;
    }
    ul.blog-single-social-sharing li a.twitter-share:hover {
        background:#55acee;
        border-color:#55acee;
    }
    ul.blog-single-social-sharing li a.google-share:hover {
        background:#dd4b39;
        border-color:#dd4b39;
    }
    ul.blog-single-social-sharing li a.pinterest-share:hover {
        background:#cb2027;
        border-color:#cb2027;
    }
    ul.blog-single-social-sharing li a.vk-share:hover{
        background:#45668e;
        border-color:#45668e;
    }
    ul.blog-single-social-sharing li a.stumble-share:hover {
        background:#ea472a;
        border-color:#ea472a;
    }
    ul.blog-single-social-sharing li a.reddit-share:hover {
        background:#fd4314;
        border-color:#fd4314;
    }
    ul.blog-single-social-sharing li a.linkedin-share:hover {
        background:#007bb6;
        border-color:#007bb6;
    }
    ul.blog-single-social-sharing li a.tumblr-share:hover {
        background:#32506d;
        border-color:#32506d;
    }
</style>
<div id="about-me-feature-main">
    <div class="ls-sc-grid_12">
        <div class="ls-sc-grid_6 about-me-element">
            <div id="page-title">
                <h1>{{ $item->getName() }}</h1>
            </div><!-- close #page-title -->
            <ul class="meta-progression-bottom" style="background: #fff;">
                    <li><i class="fa fa-calendar"></i><a href="#!" title="10:02 pm" rel="bookmark"><time class="entry-date" datetime="{{ $item->created_at }}">{{ $item->getCreatedAt() }}</time></a></li>
                    <li><i class="fa fa-user"></i><a href="{{ $item->getUserLink()}}" title="Posts by {{ $item->getUserName() }}" rel="author">{{ $item->getUserName() }}</a></li>
                    <li><i class="fa fa-folder-open"></i><a href="#!" rel="category tag">{{ $item->getCategoryLabel() }}</a></li>
                    <li><i class="fa fa-comments"></i><a href="#respond">{{ $item->getCommentsLabelSingle() }}</a></li>
                </ul>
            <!-- <h5>
            <strong>{{ $item->getCategoriesLabel() }}</strong>
            </h5> -->
            <h5>
                <strong>Fabric(s): </strong>{{ $item->getFabricsLabel() }}
            </h5>
            <p>{{ $item->description }}</p>
            <h5>
                <strong>Tags(s): </strong>
            </h5>
            <div>
                <ul id="myTags">
                    @foreach($item->tags as $tag)
                    <li>{{ $tag->name }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="prog">
                <ul class="blog-single-social-sharing">
                    <li class="social-sharing-title">Share:</li>
    
                    <li><a href="http://www.facebook.com/sharer.php?u={{ $item->getURL() }}&amp;t={{ $item->getURLName() }}" title="Share on Facebook" class="facebook-share" target="_blank"><i class="fa fa-facebook"></i></a></li>
    
                    <li><a href="https://twitter.com/share?text={{ $item->getURLName() }}&amp;url={{ $item->getURL() }}" title="Twitter" class="twitter-share" target="_blank"><i class="fa fa-twitter"></i></a></li>
        
                    <li><a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','//assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());" title="Share on Pinterest" class="pinterest-share"><i class="fa fa-pinterest"></i></a></li>

                    <li><a href="whatsapp://send" data-text="{ $item->getURLName() }}" data-href="" title="Share on Whatsapp" class="whatsapp-share" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
        
                    <li><a href="mailto:?subject={{ $item->getURLName() }}&amp;body={{ $item->getURL() }}" title="Share on E-mail" class="mail-share"><i class="fa fa-envelope"></i></a></li>
                </ul>
                <div class="clearfix-pro"></div>
            </div>
            <!-- <a href="#" class="ls-sc-button default" target="_self" title="" rel=""><span class="ls-sc-button-inner">Make Item<i class="ls-sc-button-icon-right fa fa-envelope"></i></span></a> -->
        </div><!-- close .about-me-content -->
        <div class="ls-sc-grid_6 about-me-element"><img src="{{ $item->getImage() }}" style="max-width: 100%; height: auto;">
        </div>
    </div><!-- close .about-me-content -->
    <div id="cont" class="ls-sc-grid_12">
        <!-- @php
        $currentlink = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        echo "<fb:comments href='$currentlink' num_posts='10' width='570'></fb:comments>";
        @endphp -->
        @if(Auth::check())
        <div id="respond" style="margin-left: 50px; margin-right: 50px;">
            <div id="reply-to">
            </div>
            <form class="progression-contact" id="CommentForm" method="post" action="{{ url('/item/comment') }}" novalidate="validate">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $item->id }}">
                <div>
                    <p><textarea id="ContactComment" name="text" class="textInput required" placeholder=" Your Comment" aria-required="true"></textarea></p>
                </div>
                <div>
                    <p><button type="submit" class="progression-contact-submit wpcf7-submit"><span>Send</span></button></p>
                </div>
            </form>
        </div>
        @endif
        <ul id="comments">
            @foreach($item->comments->where('parent_id', 0) as $comment)
            <li class="cmmnt">
                <div class="avatar"><a href="javascript:void(0);"><img src="{{ $comment->user->getAvatar() }}" width="55" height="55" alt="{{ $comment->user->getName() }}"></a></div>
                <div class="cmmnt-content">
                    <header><a href="javascript:void(0);" class="{{ $comment->user->getLink() }}">{{ $comment->user->getName() }}</a> - <span class="pubdate">posted {{ $comment->getTimeAgo() }}</span></header>
                    <p>{{ $comment->text }}</p>
                </div>
                <div class="reply" style="margin-bottom: 20px;"><a rel="nofollow" class="comment-reply-link" href="#respond" onclick="addReply(this, '{{$comment->user->getName()}}');" aria-label="Reply to {{$comment->user->getName()}}" id="{{ $comment->id }}">Reply</a></div>
                <ul class="replies">
                    @foreach($comment->subComments as $sub)
                    <li class="cmmnt">
                        <div class="avatar"><a href="javascript:void(0);"><img src="{{ $sub->user->getAvatar() }}" width="55" height="55" alt="{{ $sub->user->getName() }}"></a></div>
                        <div class="cmmnt-content">
                            <header><a href="javascript:void(0);" class="{{ $sub->user->getLink() }}">{{ $sub->user->getName() }}</a> - <span class="pubdate">posted {{ $sub->getTimeAgo() }}</span></header>
                            <p>{{ $sub->text }}</p>
                        </div>
                        <div class="reply" style="margin-bottom: 20px;"><a rel="nofollow" class="comment-reply-link" href="#respond" onclick="addReply(this, '{{$sub->user->getName()}}');" aria-label="Reply to {{$sub->user->getName()}}" id="{{ $sub->id }}">Reply</a></div>
                    </li>
                    @endforeach
                </ul>
            </li>
            @endforeach
        </ul>
    </div>
    @include('item.partials.related')
</div><!-- close #about-me-feature-main -->
@endsection
