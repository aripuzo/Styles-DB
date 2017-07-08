<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Form With Labels On Top</title>

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
                    <h1>Form Example</h1>
                </div>

                <div class="form-row">
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
                </div>

                <div class="form-row">
                    <label>
                        <span>Category</span>
                        <select id="ms" multiple="multiple" name="categories[]">
                            @php
                                $categories = App\Category::get();
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
                                $styles = App\Style::get();
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
                        <input type="text" name="add_style">
                    </label>
                </div>

                <div class="form-row">
                    <label>
                        <span>Fabric</span>
                        <select multiple="multiple" name="fabrics[]">
                            @php
                                $fabrics = App\Fabric::get();
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
                        <input type="text" name="add_fabric">
                    </label>
                </div>

                <div class="form-row">
                    <label>
                        <span>Color</span>
                        <select multiple="multiple" name="colors[]">
                            @php
                                $colors = App\Color::get();
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
                        <input type="text" name="add_color">
                    </label>
                </div>

                <div class="form-row">
                    <label>
                        <span>Tags</span>
                        <select multiple="multiple" name="tags[]">
                            @php
                                $tags = App\Tag::get();
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
                        <input type="text" name="add_tag">
                    </label>
                </div>

                <div class="form-row">
                    <label>
                        <span>Image</span>
                        <input type="text" name="images[]">
                    </label>
                </div>

                <div class="form-row">
                    <button type="submit">Submit Form</button>
                </div>

            </form>

        </div>
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/multiple-select.js') }}"></script>
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
