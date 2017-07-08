@extends('layouts.app')

@section('title', isset($title) ? $title : 'Page Title')
@section('description', isset($description) ? $description : 'Description')

@section('content')
<script type="text/javascript">
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });

    function likeItem(el) {
        var id = el.id,
        //sw_name = $(el).attr('name');

        alert(id);
        $.get("{{ url('item/like') }}",{'id': id}, function(data) { 
            if (data.response == "true") {
                location.reload();
                $(el).html(data.value);
            }
        });
    }
    jQuery.ajax({
        url:'/group/create',
        type: 'GET',
        data: {
            name: groupName,
            colour: "red"
        },
        success: function( data ){

            console.log(data);
        },
        error: function (xhr, b, c) {
            console.log("xhr=" + xhr + " b=" + b + " c=" + c);
        }
    });
    var showUser = $('#show-user');

    $('#my-form').on('click', function () {

        var select_id = $('#my-select').val();

        $.ajax({
            method: "POST",
            url: "/ajax",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "select_id": select_id
            },
            error: function (data) {
                //something went wrong with the request
                alert("Error");
            },
            success: function (data) {
                inner = "";
                data.forEach(function (el, i, array) {
                    inner += "<div>" + el.name + "</div>";
                });
                showUser.html(inner);
            }
        });
        event.preventDefault();
    });
</script>
<style type="text/css">
    .member > span {
        zoom: 1; /* Trigger hasLayout */
        width: 25%;
        text-align: center;
        padding: 10px;
        cursor: pointer;
    }
</style>
<div id="gallery-index-pro">
    <ul id="menu-sub-nav">
        @php
            $categories = App\Category::get();
            $i = 2;
        @endphp
        <li class="cat-item cat-item-1 {{isset($selected) && $selected == 0 ? 'current-cat' : ''}}">
            <a href="{{url('/catalogue')}}">All</a>
        </li>
        @foreach($categories as $category)
            <li class="cat-item cat-item-{{ $i }} {{isset($selected) && $selected == $category->id ? 'current-cat' : ''}}">
                <a href="{{ route('catalogue', $category->slug) }}">{{ $category->name }}</a>
            </li>
            @php
                $i += 1;
            @endphp
        @endforeach
        <li class="cat-item cat-item-15" style="float: right;">
            <button onclick="dropFunction('mySort')" class="filter-btn" style="border-color: #e9e9e9;">Sort</button>
            <div class="w3-dropdown-content w3-bar-block w3-card-2 w3-light-grey"  id="mySort">
                <a class="w3-bar-item w3-button" href="#">Popular</a>
                <a class="w3-bar-item w3-button" href="#">Latest</a>
            </div>
        </li>
        <li class="cat-item cat-item-16" style="float: right; margin-right: 80px;">
            <button onclick="dropFunction('myDIV')" class="filter-btn">Style</button>
            <div class="w3-dropdown-content w3-bar-block w3-card-2 w3-light-grey" id="myDIV">
                <input class="w3-input w3-padding" type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction('myInput', 'myDIV')">
                @php
                    $styles = App\Style::get();
                @endphp
                @foreach($styles as $style)
                    <a class="w3-bar-item w3-button" href="{{ route('style', $style->slug) }}">{{ $style->name }}</a>
                @endforeach
            </div>
        </li>
        <li class="cat-item cat-item-17" style="float: right;">
            <button onclick="dropFunction('myFabric')" class="filter-btn">Fabric</button>
            <div class="w3-dropdown-content w3-bar-block w3-card-2 w3-light-grey" id="myFabric">
                <input class="w3-input w3-padding" type="text" placeholder="Search.." id="fabricInput" onkeyup="filterFunction('fabricInput', 'myFabric')">
                @php
                    $fabrics = App\Fabric::get();
                @endphp
                @foreach($fabrics as $fabric)
                    <a class="w3-bar-item w3-button" href="{{ route('fabric', $fabric->slug) }}">{{ $fabric->name }}</a>
                @endforeach
            </div>
        </li>
    </ul>
    <div class="clearfix"></div>
    <div id="gallery-masonry-loading">
        <div id="gallery-masonry" style="position: relative; height: 966.25px;">
            @foreach($items as $item)
            <div class="gallery-item-pro gallery-column-3 opacity-pro" style="position: absolute; left: 0px; top: 0px;">
                <article>
                    <a class="gallery-container-pro" href="{{ route('item', $item->id) }}">
                    <div class="zoom-image-container-pro"><img alt="{{ $item->name }}" class="attachment-progression-gallery-index wp-post-image" height="360" src="{{ $item->images->first()->url }}" width="640"></div>
                    <div class="gallery-index-text">
                        <ul>
                            <li>{{ $item->itemCategories->first()->category->name }}<span>,</span></li>
                        </ul>
                        <div class="gallery-title-index">
                            {{ $item->name}}
                        </div>
                        <div class="member gallery-title-index" style="margin-top: 30px; font-size: 15px;">
                            <button title="Like" onclick="likeItem(this)">{{ $item->getLikesLabel() }}<i class="fa fa-heart-o"></i> </button>
                            <span title="download">{{ $item->getDownloadsLabel() }}<i class="fa fa-download"></i></span>
                            <span title="Share"> <i class="fa fa-share"></i></span>
                            <span title="Make"> Make</span>
                        </div>
                    </div></a>
                </article>
            </div>
            @endforeach
            <div class="gallery-item-pro gallery-column-3 opacity-pro" style="position: absolute; left: 357px; top: 0px;">
                <article>
                    <a class="gallery-container-pro" href="http://www.progression-studios.com/zyra/single-gallery-post.html">
                    <div class="zoom-image-container-pro"><img alt="shutterstock_158565227" class="attachment-progression-gallery-index wp-post-image" height="467" src="images/shutterstock_158565227-700x467.jpg" width="700"></div>
                    <div class="gallery-index-text">
                        <ul>
                            <li>Fashion<span>,</span></li>
                        </ul>
                        <div class="gallery-title-index">
                            Example Gallery
                        </div>
                    </div></a>
                </article>
            </div>
            <div class="gallery-item-pro gallery-column-3 opacity-pro" style="position: absolute; left: 714px; top: 0px;">
                <article>
                    <a class="gallery-container-pro" href="http://www.progression-studios.com/zyra/single-gallery-post.html">
                    <div class="zoom-image-container-pro"><img alt="shutterstock_149749034" class="attachment-progression-gallery-index wp-post-image" height="467" src="images/shutterstock_149749034-700x467.jpg" width="700"></div>
                    <div class="gallery-index-text">
                        <ul>
                            <li>Fashion<span>,</span></li>
                        </ul>
                        <div class="gallery-title-index">
                            Gallery Post
                        </div>
                    </div></a>
                </article>
            </div>
            <div class="gallery-item-pro gallery-column-3 opacity-pro" style="position: absolute; left: 0px; top: 204px;">
                <article>
                    <a class="gallery-container-pro" href="http://www.progression-studios.com/zyra/single-gallery-post.html">
                    <div class="zoom-image-container-pro"><img alt="shutterstock_173564057" class="attachment-progression-gallery-index wp-post-image" height="454" src="images/shutterstock_173564057-700x454.jpg" width="700"></div>
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
            <div class="gallery-item-pro gallery-column-3 opacity-pro" style="position: absolute; left: 357px; top: 240px;">
                <article>
                    <a class="gallery-container-pro" href="http://www.progression-studios.com/zyra/single-gallery-post.html">
                    <div class="zoom-image-container-pro"><img alt="shutterstock_164011709" class="attachment-progression-gallery-index wp-post-image" height="700" src="images/shutterstock_164011709-700x700.jpg" width="700"></div>
                    <div class="gallery-index-text">
                        <ul>
                            <li>Fashion<span>,</span></li>
                        </ul>
                        <div class="gallery-title-index">
                            Shoe Gallery
                        </div>
                    </div></a>
                </article>
            </div>
            <div class="gallery-item-pro gallery-column-3 opacity-pro" style="position: absolute; left: 714px; top: 240px;">
                <article>
                    <a class="gallery-container-pro" href="http://www.progression-studios.com/zyra/single-gallery-post.html">
                    <div class="zoom-image-container-pro"><img alt="Easily add-in image captions" class="attachment-progression-gallery-index wp-post-image" height="490" src="images/shutterstock_1541603751-700x490.jpg" width="700"></div>
                    <div class="gallery-index-text">
                        <ul>
                            <li>Fashion<span>,</span></li>
                        </ul>
                        <div class="gallery-title-index">
                            Black and White
                        </div>
                    </div></a>
                </article>
            </div>
            <div class="gallery-item-pro gallery-column-3 opacity-pro" style="position: absolute; left: 0px; top: 438px;">
                <article>
                    <a class="gallery-container-pro" href="http://www.progression-studios.com/zyra/single-gallery-post.html">
                    <div class="zoom-image-container-pro"><img alt="shutterstock_115412683" class="attachment-progression-gallery-index wp-post-image" height="467" src="images/shutterstock_115412683-700x467.jpg" width="700"></div>
                    <div class="gallery-index-text">
                        <ul>
                            <li>Fashion<span>,</span></li>
                        </ul>
                        <div class="gallery-title-index">
                            Dress Photo-shoot
                        </div>
                    </div></a>
                </article>
            </div>
            <div class="gallery-item-pro gallery-column-3 opacity-pro" style="position: absolute; left: 714px; top: 493px;">
                <article>
                    <a class="gallery-container-pro" href="http://www.progression-studios.com/zyra/single-gallery-post.html">
                    <div class="zoom-image-container-pro"><img alt="Easily add-in captions" class="attachment-progression-gallery-index wp-post-image" height="465" src="images/shutterstock_131842670-700x465.jpg" width="700"></div>
                    <div class="gallery-index-text">
                        <ul>
                            <li>Fashion<span>,</span></li>
                        </ul>
                        <div class="gallery-title-index">
                            Fashion Purse
                        </div>
                    </div></a>
                </article>
            </div>
            <div class="gallery-item-pro gallery-column-3 opacity-pro" style="position: absolute; left: 357px; top: 597px;">
                <article>
                    <a class="gallery-container-pro" href="http://www.progression-studios.com/zyra/single-gallery-post.html">
                    <div class="zoom-image-container-pro"><img alt="shutterstock_220323652" class="attachment-progression-gallery-index wp-post-image" height="495" src="images/shutterstock_220323652-700x495.jpg" width="700"></div>
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
            <div class="gallery-item-pro gallery-column-3 opacity-pro" style="position: absolute; left: 0px; top: 679px;">
                <article>
                    <a class="gallery-container-pro" href="http://www.progression-studios.com/zyra/single-gallery-post.html">
                    <div class="zoom-image-container-pro"><img alt="shutterstock_113473990" class="attachment-progression-gallery-index wp-post-image" height="559" src="images/shutterstock_1134739901-700x559.jpg" width="700"></div>
                    <div class="gallery-index-text">
                        <ul>
                            <li>Weddings<span>,</span></li>
                        </ul>
                        <div class="gallery-title-index">
                            Wedding Cake
                        </div>
                    </div></a>
                </article>
            </div>
            <div class="clearfix" style="position: absolute; left: 714px; top: 733px;"></div>
        </div><!-- close #gallery-masonry -->
    </div><!-- close #gallery-masonry -->
    <div class="clearfix"></div>
</div><!-- close #gallery-index-pro -->
<script>
    // Dropdown
    function dropFunction(id) {
        var x = document.getElementById(id);
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
        } else {
            x.className = x.className.replace(" w3-show", "");
        }
    }

    // Filter
    function filterFunction(filter_id, div) {
        var input, filter, ul, li, a, i;
        input = document.getElementById(filter_id);
        filter = input.value.toUpperCase();
        div = document.getElementById(div);
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }
    }
</script>
@endsection
