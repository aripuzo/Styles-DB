@extends('layouts.app')

@section('title', isset($title) ? $title : 'Page Title')
@section('description', isset($description) ? $description : 'Description')

@section('styles')
    <link href="{{asset('css/jquery.tagit.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/tagit.ui-zendesk.css')}}" rel="stylesheet" type="text/css">
@stop

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/tag-it.js" type="text/javascript" charset="utf-8"></script>
    <script>
        $(function(){
            var myTags = $('#myTags');

            var addEvent = function(text) {
                $('#events_container').append(text + '<br>');
            };

            myTags.tagit({
                availableTags: sampleTags,
                readOnly: true,
                onTagClicked: function(evt, ui) {
                    addEvent('onTagClicked: ' + myTags.tagit('tagLabel', ui.tag));
                },
            });
        });
    </script>
@stop

@section('content')
<style type="text/css">
    .elementor-row {
        width: 100%;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
    }
    .elementor *, .elementor :after, .elementor :before {
        /* box-sizing: border-box; */
    }
    @media (min-width: 768px){
        .elementor-column.elementor-col-50, .elementor-column[data-col="50"] {
            width: 50%;
        }
    }
    .elementor-column {
        position: relative;
        min-height: 1px;
    }
    .about-me-element {
        padding: 60px 15px 60px 15px;
        background-color: #ffffff;
    }
    .img {
       object-fit: cover;
       width: 50px;
       height: 100px;
    }
}
</style>
<div id="about-me-feature-main">
    <div class="elementor-row">
        <div class="elementor-element elementor-column elementor-col-50 elementor-top-column about-me-element">
            <div id="page-title">
                <h1>{{ $item->name }}</h1>
            </div><!-- close #page-title -->
            <ul class="meta-progression-bottom">
                    <li><i class="fa fa-calendar"></i><a href="#!" title="10:02 pm" rel="bookmark"><time class="entry-date" datetime="2015-02-20T22:02:36+00:00">February 20, 2015</time></a></li>
                    <li><i class="fa fa-user"></i><a href="#!" title="Posts by ProgressionStudios" rel="author">ProgressionStudios</a></li>
                    <li><i class="fa fa-folder-open"></i><a href="#!" rel="category tag">Uncategorized</a></li>
                    <li><i class="fa fa-comments"></i><a href="#respond">No Comments</a></li>
                </ul>
            <h5>
            <strong>{{ $item->getCategoriesLabel() }}</strong>
            </h5>
            <h5>
                <strong>Fabric(s): </strong>{{ $item->getFabricsLabel() }}
            </h5>
            <p>{{ $item->description }}</p>
            <div>
                <ul id="myTags">
                    @foreach($item->itemTags as $itemTag)
                    <li>{{ $itemTag->tag->name }}</li>
                    @endforeach
                </ul>
            </div>
            <a href="#" class="ls-sc-button default" target="_self" title="" rel=""><span class="ls-sc-button-inner">Make Item<i class="ls-sc-button-icon-right fa fa-envelope"></i></span></a>
        </div><!-- close .about-me-content -->
        <div class="elementor-element elementor-column elementor-col-50 elementor-top-column img"><img src="{{ $item->getImage() }}">
        </div>
    </div><!-- close .about-me-content -->
    <div id="related-portfolio-pro">
            <h2>Related Works</h2>
            <div class="related-columns-pro">
                <article>
                    <a class="gallery-container-pro" href="http://www.progression-studios.com/zyra/single-gallery-post.html">
                    <div class="zoom-image-container-pro"><img alt="160252896_640" class="attachment-progression-gallery-related wp-post-image" height="360" src="./Zyra Template_files/160252896_640-600x360.jpg" width="600"></div>
                    <div class="gallery-index-text">
                        <ul>
                            <li>Landscapes<span>,</span></li>
                        </ul>
                        <div class="gallery-title-index">
                            Video Example
                        </div>
                    </div></a>
                </article>
            </div>
            <div class="related-columns-pro">
                <article>
                    <a class="gallery-container-pro" href="http://www.progression-studios.com/zyra/single-gallery-post.html">
                    <div class="zoom-image-container-pro"><img alt="shutterstock_220323652" class="attachment-progression-gallery-related wp-post-image" height="450" src="./Zyra Template_files/shutterstock_220323652-600x450.jpg" width="600"></div>
                    <div class="gallery-index-text">
                        <ul>
                            <li>Landscapes<span>,</span></li>
                        </ul>
                        <div class="gallery-title-index">
                            Natural Scenery
                        </div>
                    </div></a>
                </article>
            </div>
            <div class="related-columns-pro">
                <article>
                    <a class="gallery-container-pro" href="http://www.progression-studios.com/zyra/single-gallery-post.html">
                    <div class="zoom-image-container-pro"><img alt="shutterstock_174310112" class="attachment-progression-gallery-related wp-post-image" height="450" src="./Zyra Template_files/shutterstock_1743101121-600x450.jpg" width="600"></div>
                    <div class="gallery-index-text">
                        <ul>
                            <li>Landscapes<span>,</span></li>
                        </ul>
                        <div class="gallery-title-index">
                            Travel Gallery
                        </div>
                    </div></a>
                </article>
            </div>
            <div class="clearfix"></div>
        </div><!-- #related-portfolio-pro -->
</div><!-- close #about-me-feature-main -->
@endsection
