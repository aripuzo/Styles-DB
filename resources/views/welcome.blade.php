@extends('layouts.app')

@section('content')
<div id="gallery-index-pro">
	@if(session('click') == null)
		@include('signup_prompt')
	@endif
    <ul id="menu-sub-nav">
        <li class="cat-item cat-item-1 {{(isset($order) && $order == 'latest') || !isset($order) ? 'current-cat' : ''}}">
            <a href="{{request()->fullUrlWithQuery(['sort'=>'latest'])}}">Latest</a>
        </li>
        <li class="cat-item cat-item-3 {{isset($order) && $order == 'popular' ? 'current-cat' : ''}}">
            <a href="{{request()->fullUrlWithQuery(['sort'=>'latest'])}}">Popular</a>
        </li>
    </ul>
    @include('item.partials.list')
</div><!-- close #gallery-index-pro -->
@endsection
