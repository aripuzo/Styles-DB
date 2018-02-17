<div id="search-div">
        <div id='search-box' class="sf-with-ul" style="margin-right: 20px; margin-left: 20px">
            <form class="search_bar larger" action='{{ url("/search")}}' id='search-form' method='get' target='_top'>
                <div class="search_dropdown" style="width: 19px;">
                    <select name="cat">
                        <option
                        @if(isset($cat) && $cat == 0)
                        selected
                        @endif
                         value="0">All</option>
                        @foreach($categories as $category)
                        <option
                        @if(isset($cat) && $cat == $category->id)
                        selected
                        @endif
                         value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <input id='search-box' name='q' type="text" placeholder="Search for any style, fabric or design" style="width: 84.1193%; margin-left: 75px;">
                <div id="search-suggesstion-box"></div>
                <button type="submit" value="Search">Search</button>
            </form>
        </div>
    </div>