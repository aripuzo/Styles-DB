@extends('layouts.app')

@section('content')
<div id="gallery-index-pro">
    <ul id="menu-sub-nav">
    	@php
            $i = 2;
        @endphp
    	@foreach($categories as $category)
            <li class="cat-item cat-item-{{ $i }} {{isset($selected) && $selected == $category->id ? 'current-cat' : ''}}">
                <a href="{{ route('catalogue', $category->slug) }}">{{ $category->name }}</a>
            </li>
            @php
                $i += 1;
            @endphp
        @endforeach
        <li style="padding: 0; float: right;">
            <ul style="padding: 0; margin: 0">
                <li style="border: none;" class="{{isset($order) && $order == 'popular' ? 'current-cat' : ''}}"><a href="{{request()->fullUrlWithQuery(['sort'=>'popular'])}}">Popular</a></li>
                <li style="border: none;" class="{{isset($order) && $order == 'latest' ? 'current-cat' : ''}}"><a href="{{request()->fullUrlWithQuery(['sort'=>'latest'])}}">Latest</a></li>
            </ul>
        </li>
    </ul>
    @include('item.partials.list')
</div><!-- close #gallery-index-pro -->
@endsection
