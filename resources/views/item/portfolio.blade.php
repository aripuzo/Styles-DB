@extends('layouts.app')

@section('content')
<div id="gallery-index-pro">
    @include('search')
    <ul id="menu-sub-nav">
        @php
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
        <li style="padding: 0; float: right;">
            <ul style="padding: 0; margin: 0">
                <li style="border: none;" class="{{isset($order) && $order == 'popular' ? 'current-cat' : ''}}"><a href="{{request()->fullUrlWithQuery(['sort'=>'popular'])}}">Popular</a></li>
                <li style="border: none;" class="{{isset($order) && $order == 'latest' ? 'current-cat' : ''}}"><a href="{{request()->fullUrlWithQuery(['sort'=>'latest'])}}">Latest</a></li>
            </ul>
        </li>
        <li class="cat-item cat-item-16" style="float: right; margin-right: 80px;">
            <button onclick="dropFunction('myDIV')" class="filter-btn">Style</button>
            <div class="w3-dropdown-content w3-bar-block w3-card-2 w3-light-grey" id="myDIV">
                <input class="w3-input w3-padding" type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction('myInput', 'myDIV')">
                @foreach($styles as $style)
                    <a class="w3-bar-item w3-button" href="{{ route('style', $style->slug) }}" style="margin: 0">{{ $style->name }}</a>
                @endforeach
            </div>
        </li>
        <li class="cat-item cat-item-17" style="float: right;">
            <button onclick="dropFunction('myFabric')" class="filter-btn">Fabric</button>
            <div class="w3-dropdown-content w3-bar-block w3-card-2 w3-light-grey" id="myFabric">
                <input class="w3-input w3-padding" type="text" placeholder="Search.." id="fabricInput" onkeyup="filterFunction('fabricInput', 'myFabric')">
                @foreach($fabrics as $fabric)
                    <a class="w3-bar-item w3-button" href="{{ route('fabric', $fabric->slug) }}" style="margin: 0">{{ $fabric->name }}</a>
                @endforeach
            </div>
        </li>
    </ul>
    @include('item.partials.list')
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
