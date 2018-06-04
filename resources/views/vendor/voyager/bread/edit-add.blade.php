@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager.generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular)

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager.generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form"
                            class="form-edit-add"
                            action="@if(isset($dataTypeContent->id)){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->id) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"
                            method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        @if(isset($dataTypeContent->id))
                            {{ method_field("PUT") }}
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Adding / Editing -->
                            @php
                                $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                            @endphp

                            @foreach($dataTypeRows as $row)
                                <!-- GET THE DISPLAY OPTIONS -->
                                @php
                                    $options = json_decode($row->details);
                                    $display_options = isset($options->display) ? $options->display : NULL;
                                @endphp
                                @if ($options && isset($options->formfields_custom))
                                    @include('voyager::formfields.custom.' . $options->formfields_custom)
                                @else
                                    <div class="form-group @if($row->type == 'hidden') hidden @endif @if(isset($display_options->width)){{ 'col-md-' . $display_options->width }}@else{{ '' }}@endif" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                        {{ $row->slugify }}
                                        <label for="{{ $row->field }}">{{ $row->display_name }}</label>
                                        
                                        @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                            {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                        @endforeach
                                        
                                        @include('voyager::multilingual.input-hidden-bread-edit-add')
                                        @if($row->type == 'relationship')
                                            @include('voyager::formfields.relationship')
                                        @else
                                            {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                        @endif


                                    </div>
                                @endif
                            @endforeach

                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            <button type="submit" name="save" class="btn btn-primary save">{{ __('voyager.generic.save') }}</button>
                            &nbsp;&nbsp;&nbsp;
                            <button type="submit" name="update" class="btn btn-success update">Применить</button>
                            &nbsp;&nbsp;&nbsp;
                            <button class="btn btn-light cancel">Отменить</button>
                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                            enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                                 onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                        {{ csrf_field() }}
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager.generic.are_you_sure') }}</h4>
                </div>

                <div class="modal-body">
                    <h4>{{ __('voyager.generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager.generic.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager.generic.delete_confirm') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete File Modal -->
@stop

@section('javascript')
    <script>
        var params = {};
        var $image;

        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.type != 'date' || elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                }
            });

            @if ($isModelTranslatable)
                $('.side-body').multilingual({"editing": true});
            @endif

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', function (e) {
                $image = $(this).siblings('img');

                params = {
                    slug:   '{{ $dataType->slug }}',
                    image:  $image.data('image'),
                    id:     $image.data('id'),
                    field:  $image.parent().data('field-name'),
                    _token: '{{ csrf_token() }}'
                }

                $('.confirm_delete_name').text($image.data('image'));
                $('#confirm_delete_modal').modal('show');
            });

            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $image.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing image.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();
            
            
            $("input#name").on("keyup", function() {
	            $("input#code").val(urlRusLat($(this).val()));
            });
            
            
            $(".panel-footer .cancel").on("click", function(e) {
	            e.preventDefault();
	            window.history.back();
            });
        });
        
  
  
		//Транслитерация кириллицы в URL
		function urlRusLat(str) {
			str = str.toLowerCase(); // все в нижний регистр
				var cyr2latChars = new Array(
						['а', 'a'], ['б', 'b'], ['в', 'v'], ['г', 'g'],
						['д', 'd'],  ['е', 'e'], ['ё', 'yo'], ['ж', 'zh'], ['з', 'z'],
						['и', 'i'], ['й', 'y'], ['к', 'k'], ['л', 'l'],
						['м', 'm'],  ['н', 'n'], ['о', 'o'], ['п', 'p'],  ['р', 'r'],
						['с', 's'], ['т', 't'], ['у', 'u'], ['ф', 'f'],
						['х', 'h'],  ['ц', 'c'], ['ч', 'ch'],['ш', 'sh'], ['щ', 'shch'],
						['ъ', ''],  ['ы', 'y'], ['ь', ''],  ['э', 'e'], ['ю', 'yu'], ['я', 'ya'],
						
						['А', 'A'], ['Б', 'B'],  ['В', 'V'], ['Г', 'G'],
						['Д', 'D'], ['Е', 'E'], ['Ё', 'YO'],  ['Ж', 'ZH'], ['З', 'Z'],
						['И', 'I'], ['Й', 'Y'],  ['К', 'K'], ['Л', 'L'],
						['М', 'M'], ['Н', 'N'], ['О', 'O'],  ['П', 'P'],  ['Р', 'R'],
						['С', 'S'], ['Т', 'T'],  ['У', 'U'], ['Ф', 'F'],
						['Х', 'H'], ['Ц', 'C'], ['Ч', 'CH'], ['Ш', 'SH'], ['Щ', 'SHCH'],
						['Ъ', ''],  ['Ы', 'Y'],
						['Ь', ''],
						['Э', 'E'],
						['Ю', 'YU'],
						['Я', 'YA'],
						
						['a', 'a'], ['b', 'b'], ['c', 'c'], ['d', 'd'], ['e', 'e'],
						['f', 'f'], ['g', 'g'], ['h', 'h'], ['i', 'i'], ['j', 'j'],
						['k', 'k'], ['l', 'l'], ['m', 'm'], ['n', 'n'], ['o', 'o'],
						['p', 'p'], ['q', 'q'], ['r', 'r'], ['s', 's'], ['t', 't'],
						['u', 'u'], ['v', 'v'], ['w', 'w'], ['x', 'x'], ['y', 'y'],
						['z', 'z'],
						
						['A', 'A'], ['B', 'B'], ['C', 'C'], ['D', 'D'],['E', 'E'],
						['F', 'F'],['G', 'G'],['H', 'H'],['I', 'I'],['J', 'J'],['K', 'K'],
						['L', 'L'], ['M', 'M'], ['N', 'N'], ['O', 'O'],['P', 'P'],
						['Q', 'Q'],['R', 'R'],['S', 'S'],['T', 'T'],['U', 'U'],['V', 'V'],
						['W', 'W'], ['X', 'X'], ['Y', 'Y'], ['Z', 'Z'],
						
						[' ', '_'],['0', '0'],['1', '1'],['2', '2'],['3', '3'],
						['4', '4'],['5', '5'],['6', '6'],['7', '7'],['8', '8'],['9', '9'],
						['-', '-']
		
		    );
		
		    var newStr = new String();
		
		    for (var i = 0; i < str.length; i++) {
		
		        ch = str.charAt(i);
		        var newCh = '';
		
		        for (var j = 0; j < cyr2latChars.length; j++) {
		            if (ch == cyr2latChars[j][0]) {
		                newCh = cyr2latChars[j][1];
		
		            }
		        }
		        // Если найдено совпадение, то добавляется соответствие, если нет - пустая строка
		        newStr += newCh;
		
		    }
		    // Удаляем повторяющие знаки - Именно на них заменяются пробелы.
		    // Так же удаляем символы перевода строки, но это наверное уже лишнее
		    return newStr.replace(/[_]{2,}/gim, '_').replace(/\n/gim, '');
		}      

        
        
    </script>
@stop
