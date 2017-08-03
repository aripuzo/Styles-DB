@extends('layouts.app')

@section('title', isset($title) ? $title : 'Page Title')
@section('description', isset($description) ? $description : 'Description')

@section('content')
<div id="gallery-index-pro">
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
                    <div class="zoom-image-container-pro"><img alt="{{ $item->getName() }}" class="attachment-progression-gallery-index wp-post-image" height="auto" src="{{ $item->getImage() }}" width="640"></div>
                    <div class="gallery-index-text">
                        <ul>
                            @php
                            $item->getCategoriesLabel();
                            @endphp
                        </ul>
                        <div class="gallery-title-index">
                            {{ $item->getName()}}
                        </div>
                    </div></a>
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
</div><!-- close #gallery-index-pro -->
@endsection
