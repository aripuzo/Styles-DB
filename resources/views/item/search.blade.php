@extends('layouts.app')

@section('content')
<div id="gallery-index-pro">
    <ul id="menu-sub-nav">
        <li class="cat-item cat-item-1">
        <h4>Search '{{ $term }}'</h4>
        </li>
    </ul>
    @include('item.partials.list')
    
    <div class="clearfix"></div>
</div><!-- close #gallery-index-pro -->
@endsection
