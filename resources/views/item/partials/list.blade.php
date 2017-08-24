@section('scripts')
<script type="text/javascript">
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
    function likeItem(el) {
        event.preventDefault();
        @if (Auth::check())
        var id = el.id;

        jQuery.ajax({
            method: "GET",
            url: "{{ url('item/like') }}",
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "id": id
            },
            error: function (data) {
                alert("Server error, please try again");
            },
            success: function (data) {
                if (data.response == true) {
                    el.innerHTML = data.value;
                }
                else
                    alert(data.message);
            }
        });
        @else
            alert('Please login or register to perform action');
        @endif
    }
    function bookmarkItem(el) {
        event.preventDefault();
        @if (Auth::check())
        var id = el.id;

        jQuery.ajax({
            method: "GET",
            url: "{{ url('item/bookmark') }}",
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "id": id
            },
            error: function (data) {
                alert("Server error, please try again");
            },
            success: function (data) {
                if (data.response == true) {
                    el.innerHTML = data.value;
                }
                else
                    alert(data.message);
            }
        });
        @else
            alert('Please login or register to perform action');
        @endif
    }
    function downloadItem(el) {
        event.preventDefault();
        var id = el.id;
        jQuery.ajax({
            method: "GET",
            url: "{{ url('item/download') }}",
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "id": id
            },
            error: function (data) {
                alert("Server error, please try again");
            },
            success: function (data) {
                //alert(data);
                if (data.response == true) {
                    var a = document.createElement("a");
                    a.href = data.url;
                    a.download = data.filename; // Set the file name.
                    a.style.display = 'none';
                    document.body.appendChild(a);
                    a.click();
                    delete a;
                }
                else
                    alert(data.message);
            }
        });
    }
    function makeItem(el) {
        event.preventDefault();
        window.location.href = el.id;
    }
    var page = 1;
    var load = true;
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height() && !$('.ajax-load').is(":visible")) {
            page++;
            loadMoreData(page);
        }
    });

    function loadMoreData(page){
        jQuery.ajax({
            method: "GET",
            url: '?page=' + page,
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(){
                jQuery('.ajax-load').show();
            },
            error: function (data) {
                alert("Server error, please try again");
            },
            success: function (data) {
                //alert(data);
                if(data.html == " "){
                    $('.ajax-load').html("No more records found");
                    $('.ajax-load').show();
                    load = false;
                    return;
                }
                $('.ajax-load').hide();
                $("#gallery-masonry").append(data.html);
            }
        });
    }
</script>
@stop
@section('styles')
<style type="text/css">
    .member > span {
        zoom: 1; /* Trigger hasLayout */
        width: 25%;
        text-align: center;
        padding: 10px;
        cursor: pointer;
    }
    .bottom{
        padding: 0 16px;
        position: relative;
        display: flex;
        background-color: #ffffff;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-flex-shrink: 0;
        -ms-flex-negative: 0;
        flex-shrink: 0;
        margin: 0;
        display: none;
    }
    .button-section{
        margin-top: 4px;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -webkit-flex-direction: row;
        -ms-flex-direction: row;
        flex-direction: row;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        flex-shrink: 0;
        margin: 0;
        padding: 0;
        position: relative;
    }
    .button-section > span {
        zoom: 1; /* Trigger hasLayout */
        width: 25%;
        text-align: center;
        padding: 14px;
        cursor: pointer;
    }

    @media only screen and (max-width: 767px){
        a.gallery-container-pro {
            height: 80%;
        }
        .gallery-index-text {
            display: none;
        }
        .bottom{
            display: block;
        }
    }
    .ajax-load{
        padding: 10px 0px;
        width: 100%;
    }

</style>
@endsection
<div class="clearfix"></div>
<div id="gallery-masonry-loading">
    <div id="gallery-masonry" style="position: relative; height: 966.25px;">
        @include('item.partials.data')
        <div class="clearfix" style="position: absolute; left: 714px; top: 733px;"></div>
    </div><!-- close #gallery-masonry -->
</div><!-- close #gallery-masonry -->
<div class="clearfix"></div>
@if(config('settings.loadMore'))
<div class="ajax-load text-center" style="display:none">
    <p><img src="{{ asset('images/loader.gif') }}">Loading More post</p>
</div>
@else
@include('pagination.default', ['paginator' => $items])
@endif
<div class="clearfix"></div>
