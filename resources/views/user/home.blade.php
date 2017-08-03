@extends('layouts.app')

@section('title', isset($title) ? $title : 'Page Title')
@section('description', isset($description) ? $description : 'Description')

@section('content')
<div id="gallery-index-pro">
    <ul id="menu-sub-nav">
        <li class="cat-item cat-item-1 {{(isset($order) && $order == 'recommended') || !isset($order) ? 'current-cat' : ''}}">
            <a href="{{request()->fullUrlWithQuery(['sort'=>'recommended'])}}">Recommended</a>
        </li>
        <li class="cat-item cat-item-2 {{(isset($order) && $order == 'latest') || !isset($order) ? 'current-cat' : ''}}">
            <a href="{{request()->fullUrlWithQuery(['sort'=>'latest'])}}">Latest</a>
        </li>
        <li class="cat-item cat-item-3 {{(isset($order) && $order == 'popular') || !isset($order) ? 'current-cat' : ''}}">
            <a href="{{request()->fullUrlWithQuery(['sort'=>'popular'])}}">Popular</a>
        </li>
    </ul>
    @include('item.partials.list')
</div><!-- close #gallery-index-pro -->
@endsection
