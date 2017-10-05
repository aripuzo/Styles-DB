<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>New Style</title>

        <link rel="stylesheet" href="{{ asset('css/demo.css') }}">
        <link rel="stylesheet" href="{{ asset('css/form-labels-on-top.css') }}">
        <link rel="stylesheet" href="{{ asset('css/multiple-select.css') }}" />
    </head>
    <body data-gr-c-s-loaded="true">
        <div class="main-content">

            <!-- You only need this form and the form-labels-on-top.css -->

            <form class="form-labels-on-top" method="post" action="{{ url('/styles/build') }}">
                {{ csrf_field() }}
                <div class="form-title-row">
                    <h1>New</h1>
                </div>

                <!-- <div class="form-row">
                    <label>
                        <span>Name</span>
                        <input type="text" name="name">
                    </label>
                </div>

                <div class="form-row">
                    <label>
                        <span>Description</span>
                        <input type="text" name="description">
                    </label>
                </div> -->

                <div class="form-row">
                    <label>
                        <span>Category</span>
                        <select id="ms" multiple="multiple" name="categories[]">
                            @php
                                $categories = App\Models\Category::get();
                            @endphp
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="form-row">
                    <label>
                        <span>Style</span>
                        <select multiple="multiple" name="styles[]">
                            @php
                                $styles = App\Models\Style::get();
                            @endphp
                            @foreach($styles as $style)
                                <option value="{{ $style->id }}">{{ $style->name }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="form-row">
                    <label>
                        <span>Additional Styles</span>
                        <input type="text" name="add_styles">
                    </label>
                </div>

                <div class="form-row">
                    <label>
                        <span>Fabric</span>
                        <select multiple="multiple" name="fabrics[]">
                            @php
                                $fabrics = App\Models\Fabric::get();
                            @endphp
                            @foreach($fabrics as $fabric)
                                <option value="{{ $fabric->id }}">{{ $fabric->name }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="form-row">
                    <label>
                        <span>Additional Fabrics</span>
                        <input type="text" name="add_fabrics">
                    </label>
                </div>

                <div class="form-row">
                    <label>
                        <span>Color</span>
                        <select multiple="multiple" name="colors[]">
                            @php
                                $colors = App\Models\Color::get();
                            @endphp
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="form-row">
                    <label>
                        <span>Additional Colors</span>
                        <input type="text" name="add_colors">
                    </label>
                </div>

                <div class="form-row">
                    <label>
                        <span>Tags</span>
                        <select multiple="multiple" name="tags[]">
                            @php
                                $tags = App\Models\Tag::get();
                            @endphp
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="form-row">
                    <label>
                        <span>Additional Tags</span>
                        <input type="text" name="add_tags">
                    </label>
                </div>

                <div class="form-row">
                    <label>
                        <span>Image</span>
                        <input type="text" name="images[]" value="http://res.cloudinary.com/oversabi/image/upload/v1478518325/">
                    </label>
                </div>

                <div class="form-row">
                    <button type="submit">Submit Form</button>
                </div>

            </form>

        </div>
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/multiple-select.js') }}"></script>
        <!-- RevSlider -->
    <script src="{{ asset('js/revolution-slider.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.themepunch.tools.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.themepunch.revolution.min.js') }}"></script>

    <!-- SLIDER REVOLUTION 5.0 EXTENSIONS
        (Load Extensions only on Local File Systems !
         The following part can be removed on Server for On Demand Loading) -->
    <script type="text/javascript" src="{{ asset('js/revolution.extension.actions.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/revolution.extension.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/revolution.extension.kenburn.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/revolution.extension.layeranimation.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/revolution.extension.migration.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/revolution.extension.navigation.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/revolution.extension.parallax.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/revolution.extension.parallax.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/revolution.extension.parallax.min.js') }}"></script>
        <script>
            $(function() {
                $('#ms').change(function() {
                    console.log($(this).val());
                }).multipleSelect({
                    width: '100%'
                });
            });
        </script>
    </body>
</html>
