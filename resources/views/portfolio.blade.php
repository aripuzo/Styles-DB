@extends('layouts.app')

@section('content')
<script type="text/javascript">
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
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

    $('#my-form').on('submit', function () {

        var select_id = $('#my-select').val();

        $.ajax({
            method: "POST",
            url: "ajax",
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
<div id="gallery-index-pro">
    <ul id="menu-sub-nav">
        <li class="cat-item cat-item-7 current-cat">
            <a href="#">All</a>
        </li>
        <li class="cat-item cat-item-8">
            <a href="#">Men</a>
        </li>
        <li class="cat-item cat-item-9">
            <a href="#">Women</a>
        </li>
        <li class="cat-item cat-item-10">
            <a href="#">Kids</a>
        </li>
        <li class="cat-item cat-item-15" style="float: right; margin-right: 80px;">
            <button onclick="dropFunction('myDIV')" class="filter-btn">Style</button>
            <div class="w3-dropdown-content w3-bar-block w3-card-2 w3-light-grey" id="myDIV">
                <input class="w3-input w3-padding" type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction('myInput', 'myDIV')">
                <a class="w3-bar-item w3-button" href="{{ route('style', 'buba') }}">Buba</a>
                <a class="w3-bar-item w3-button" href="#base">Senatore</a>
                <a class="w3-bar-item w3-button" href="#blog">Agbada</a>
                <a class="w3-bar-item w3-button" href="#contact">Caftan</a>
                <a class="w3-bar-item w3-button" href="#custom">Gown</a>
            </div>
        </li>
        <li class="cat-item cat-item-15" style="float: right;">
            <button onclick="dropFunction('myFabric')" class="filter-btn">Fabric</button>
            <div class="w3-dropdown-content w3-bar-block w3-card-2 w3-light-grey" id="myFabric">
                <input class="w3-input w3-padding" type="text" placeholder="Search.." id="fabricInput" onkeyup="filterFunction('fabricInput', 'myFabric')">
                <a class="w3-bar-item w3-button" href="#about">Ankara</a>
                <a class="w3-bar-item w3-button" href="#base">Lace</a>
                <a class="w3-bar-item w3-button" href="#blog">English</a>
                <a class="w3-bar-item w3-button" href="#contact">Atiku</a>
                <a class="w3-bar-item w3-button" href="#custom">Cotton</a>
            </div>
        </li>
    </ul>
    <div class="clearfix"></div>
    <div id="gallery-masonry-loading">
        <div id="gallery-masonry" style="position: relative; height: 966.25px;">
            <div class="gallery-item-pro gallery-column-3 opacity-pro" style="position: absolute; left: 0px; top: 0px;">
                <article>
                    <a class="gallery-container-pro" href="http://www.progression-studios.com/zyra/single-gallery-post.html">
                    <div class="zoom-image-container-pro"><img alt="160252896_640" class="attachment-progression-gallery-index wp-post-image" height="360" src="images/160252896_640.jpg" width="640"></div>
                    <div class="gallery-index-text">
                        <ul>
                            <li>Landscapes<span>,</span></li>
                        </ul>
                        <div class="gallery-title-index">
                            Video Example
                        </div>
                        <div class="gallery-title-index">
                            <span><i class="fa fa-heart-o"></i></span>
                            <span><i class="fa fa-share-alt"></i></span>
                        </div>
                    </div></a>
                </article>
            </div>
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
