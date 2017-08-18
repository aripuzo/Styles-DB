@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/jquery.tagit.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/tagit.ui-zendesk.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/dropzone.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.multiselect.css')}}">
    <style>
        #designer-list{float:left;list-style:none;margin-top:-3px;padding:0;width:190px;position: absolute;}
        #designer-list li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid; z-index:10;}
        #designer-list li:hover{background:#ece3d2;cursor: pointer;}
        #designer-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
    </style>
@endsection
@section('scripts')
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script> -->
    <script src="{{asset('js/tag-it.js')}}" type="text/javascript" charset="utf-8"></script>
    <script>
        jQuery(function(){
            var myTags = jQuery('#myTags');

            myTags.tagit({
                readOnly: false,
                singleField: true,
                label: 'Test',
                fieldName: 'tags',
                itemName: 'Tags'
            });
        });
    </script>
    <script>
    $(document).ready(function(){
        $("#designer-box").keyup(function(){
            $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            url: "designer-suggestion",
            data:'keyword='+$(this).val(),
            beforeSend: function(){
                $("#designer-box").css("background","#FFF url(images/LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){
                $("#designer-suggesstion-box").show();
                $("#designer-suggesstion-box").html(data.value);
                $("#designer-box").css("background","#FFF");
            }
            });
        });
    });

    function selectDesigner(val) {
        $("#designer-box").val(val);
        $("#designer-suggesstion-box").hide();
    }
    </script>
@endsection

@section('content')
<style type="text/css">
    .ls-sc-grid_12 {
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        background-color: #ffffff;
        margin: 0;
    }
    @media screen and (max-width: 640px) {
        .ls-sc-grid_12 {
            display: block;
        }
    }
    .about-me-element {
        padding: 60px 15px 60px 15px;
    }
    .img {
       object-fit: cover;
       height: auto;
    }
}
</style>
<div id="about-me-feature-main">
    <div class="ls-sc-grid_12">
        <div class="ls-sc-grid_6 about-me-element">
            <div id="cropContainerEyecandy">
                <div class="dz-message">

                </div>

                <div class="fallback">
                    <input name="file" type="file" multiple />
                </div>

                <div class="dropzone-previews" id="dropzonePreview"></div>

                <h4 style="text-align: center;color:#428bca;">Drop images in this area  <span class="glyphicon glyphicon-hand-down"></span></h4>
            </div>
        </div>
        <div class="ls-sc-grid_6 about-me-element">
            <div id="content-container-pro">
                <div class="wpcf7">
                    <form class="progression-contact" id="CommentForm" method="post" action="{{url('/submit')}}" novalidate="novalidate">
                        {{ csrf_field() }}
                        <fieldset>
                            <div class="frmSearch">
                                <input id="designer-box" name="designer" type="text" class="textInput" placeholder="Name of Designer/Tailor (optional)">
                                <div id="designer-suggesstion-box" style="z-index: 1000;"></div>
                            </div>
                            <div>
                                <p>
                                <select name="categories[]" multiple id="category">
                                @php
                                $categories = App\Models\Category::get();
                                @endphp
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                                </select>
                                </p>
                            </div>
                            <div>
                                <p>
                                <select name="styles[]" multiple id="style">
                                @php
                                $styles = App\Models\Style::get();
                                @endphp
                                @foreach($styles as $style)
                                    <option value="{{ $style->id }}">{{ $style->name }}</option>
                                @endforeach
                                </select>
                                </p>
                            </div>
                            <div>
                                <p>
                                <select name="fabrics[]" multiple id="fabric">
                                @php
                                $fabrics = App\Models\Fabric::get();
                                @endphp
                                @foreach($fabrics as $fabric)
                                    <option value="{{ $fabric->id }}">{{ $fabric->name }}</option>
                                @endforeach
                                </select>
                                </p>
                            </div>
                            <div>
                                <ul id="myTags">
                                </ul>
                                Press 'enter' or 'comma' key after each tag
                            </div>
                            @if(!Auth::check())
                            Please enter your email registered or not
                            <div style="margin-top: 20px">
                                <p><input class="textInput email" type="email" name="email"></p>
                            </div>
                            @endif
                            <div style="margin-top: 30px;">
                                <p><button type="submit" class="progression-contact-submit wpcf7-submit"><span>Update</span></button></p>
                            </div>
                        </fieldset>
                    </form> 
                </div>
                <div class="clearfix"></div>
            </div>          
        </div>
    </div>
</div><!-- close #about-me-feature-main -->
<!-- Dropzone Preview Template -->
    <div id="preview-template" style="display: none;">

        <div class="dz-preview dz-file-preview">
            <div class="dz-image"><img data-dz-thumbnail=""></div>

            <div class="dz-details">
                <div class="dz-size"><span data-dz-size=""></span></div>
                <div class="dz-filename"><span data-dz-name=""></span></div>
            </div>
            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
            <div class="dz-error-message"><span data-dz-errormessage=""></span></div>

            <div class="dz-success-mark">
                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                    <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                    <title>Check</title>
                    <desc>Created with Sketch.</desc>
                    <defs></defs>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                        <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                    </g>
                </svg>
            </div>

            <div class="dz-error-mark">
                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                    <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                    <title>error</title>
                    <desc>Created with Sketch.</desc>
                    <defs></defs>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                        <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                            <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
                        </g>
                    </g>
                </svg>
            </div>

        </div>
    </div>
    <!-- End Dropzone Preview Template -->
<script src="{{asset('js/dropzone.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('js/dropzone-config.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('js/jquery.multiselect.js')}}"></script>
<script type="text/javascript">
    $('#category').multiselect({
        columns: 1,
        placeholder: 'Select category'
    });
    $('#style').multiselect({
        columns: 1,
        placeholder: 'Select style(s)',
        search: true
    });
    $('#fabric').multiselect({
        columns: 1,
        placeholder: 'Select fabric(s)',
        search: true
    });
</script>
@endsection
