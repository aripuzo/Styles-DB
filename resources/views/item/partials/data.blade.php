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
                <div class="gallery-title-text">
                    {{ $item->getDesigner()}}
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
