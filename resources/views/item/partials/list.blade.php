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
    
</style>
@endsection
<div class="clearfix"></div>
<div id="gallery-masonry-loading">
    <div id="gallery-masonry" style="position: relative; height: 966.25px;">
        @php
        $i = 0;
        @endphp
        @foreach($items as $item)
            @if($i == 0)
            <div class="gallery-item-pro gallery-column-3 opacity-pro" style="position: absolute; left: 0px; top: 0px;">
            @elseif($i == 1)
            <div class="gallery-item-pro gallery-column-3 opacity-pro" style="position: absolute; left: 375px; top: 0px;">
            @else
            <div class="gallery-item-pro gallery-column-3 opacity-pro" style="position: absolute; left: 714px; top: 0px;">
            @endif
                <article>
                    <a class="gallery-container-pro" href="{{ route('item', $item->id) }}">
                        <div class="zoom-image-container-pro">
                            <img alt="{{ $item->getName() }}" class="attachment-progression-gallery-index wp-post-image" height="auto" src="{{ $item->getImage() }}" width="640">
                        </div>
                        <div class="gallery-index-text">
                            <ul>
                                @php
                                $item->getCategoriesLabel();
                                @endphp
                            </ul>
                            <div class="gallery-title-index">
                                {{ $item->getName()}}
                            </div>
                            <div class="member gallery-title-index" style="margin-top: 30px; font-size: 15px;">
                                @php
                                if(Auth::check()){
                                    if(isset(Auth::user()->favorites))
                                        $liked = Auth::user()->favorites->where('item_id', $item->id)->first();
                                    if(isset(Auth::user()->bookmarks))
                                        $booked = Auth::user()->bookmarks->where('item_id', $item->id)->first();
                                }
                                @endphp
                                <span id="{{ $item->id }}" title="Like" onclick="likeItem(this);">{{ $item->getLikesLabel() }} <i class="fa fa-heart{{ isset($liked) ? '' : '-o' }}"></i> </span>
                                <span id="{{ $item->id }}" title="bookmark" onclick="bookmarkItem(this);">{{ $item->getBookmarksLabel() }} <i class="fa fa-bookmark{{ isset($booked) ? '' : '-o' }}"></i></span>
                                <span id="{{ $item->id }}" title="download" onclick="downloadItem(this);">{{ $item->getDownloadsLabel() }} <i class="fa fa-download"></i></span>
                                <span title="Comment"><span class="fb-comments-count" data-href="{{ route('item', $item->id) }}"></span>{{ $item->getCommentsLabel() }} <i class="fa fa-comment"></i></span>
                                <!-- <span id="{{ route('make_item', $item->id) }}" title="Make" onclick="makeItem(this);"> Make</span> -->
                            </div>
                        </div>
                    </a>
                    <div class="bottom">
                        <div class="gallery-title-index">
                            {{ $item->getName()}}
                        </div>
                        <div class="button-section">
                            <span id="{{ $item->id }}" title="Like" onclick="likeItem(this);">{{ $item->getLikesLabel() }} <i class="fa fa-heart{{ isset($liked) ? '' : '-o' }}"></i> </span>
                            <span id="{{ $item->id }}" title="bookmark" onclick="bookmarkItem(this);">{{ $item->getBookmarksLabel() }} <i class="fa fa-bookmark{{ isset($booked) ? '' : '-o' }}"></i></span>
                            <span id="{{ $item->id }}" title="download" onclick="downloadItem(this);">{{ $item->getDownloadsLabel() }} <i class="fa fa-download"></i></span>
                            <span title="Comment"><span class="fb-comments-count" data-href="{{ route('item', $item->id) }}"></span>{{ $item->getCommentsLabel() }} <i class="fa fa-comment"></i></span>
                        </div>
                    </div>
                </article>
            </div>
            @php
            $i++;
            if($i == 3)
                $i = 0;
            @endphp
            @endforeach
            <div class="clearfix" style="position: absolute; left: 714px; top: 733px;"></div>
        </div><!-- close #gallery-masonry -->
    </div><!-- close #gallery-masonry -->
    <div class="clearfix"></div>
    @include('pagination.default', ['paginator' => $items])
<div class="clearfix"></div>
