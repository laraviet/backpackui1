@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
      <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
      <small id="datatable_info_stack">{!! $crud->getSubheading() ?? trans('backpack::crud.all').'<span>'.$crud->entity_name_plural.'</span> '.trans('backpack::crud.in_the_database') !!}.</small>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.list') }}</li>
	  </ol>
	</section>
@endsection

@section('content')
<!-- Default box -->
  <div class="row">

    <!-- THE ACTUAL CONTENT -->
    <div class="{{ $crud->getListContentClass() }}">
      <div class="">
        <div class="row m-b-10">
            <div class="col-xs-12">
                @if ( $crud->buttons->where('stack', 'top')->count() ||  $crud->exportButtons())
                    <div class="hidden-print {{ $crud->hasAccess('create')?'with-border':'' }}">
                        @include('crud::inc.button_stack', ['stack' => 'top'])
                    </div>
                @endif
          </div>
        </div>

        @if(isset($hideCreatePanel))
        @else
        <div class="box box-info collapsed-box m-b-20">
            <div class="box-header with-border">
                <h3 class="box-title">
                <span class="fa fa-fw fa-plus"></span> Add {{ $crud->entity_name }} </h3>
                <button type="button" class="btn btn-box-tool" data-widget="collapse" style="position: absolute; top: 4px; right: 0; width: 100%; text-align: right; margin-top: -5px; height: 100%; padding-right: 10px; outline: 0;">
                </button>
            </div>
            <div class="box-body">
                <form method="post" action="{{ url($crud->route) }}"
                    @if ($crud->hasUploadFields('create'))
				        enctype="multipart/form-data"
				    @endif
		  		>
		            {!! csrf_field() !!}
		            <div class="col-md-12">
		                <div class="row display-flex-wrap">
		                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      	            @include('backpackui1::theme.form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
		                </div><!-- /.box-body -->
                        <div class="text-center">
                            <div id="saveActions" class="form-group">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-success">
                                        <span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                        <span data-value="save_and_back">Save</span>
                                    </button>
                                </div>
                            </div>
                        </div>
		            </div><!-- /.box -->
		        </form>
            </div>
        </div>
        @endif

        <div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        <div class="row">
                            <div class="col-xs-6">
                                <h4>Manage {{ $crud->entity_name_plural }}</h4>
                            </div>
                            <div class="col-xs-6">
                                <div id="datatable_search_stack" class="pull-right"></div>              
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="panel-body">
                    @if ($crud->filtersEnabled())
                        <div class="box box-info m-b-20">
                            <div class="box-header with-border">
                                @include('crud::inc.filters_navbar')
                            </div>
                        </div>
                    @endif
                    <table id="crudTable" class="box table table-bordered table-striped table-hover display responsive nowrap m-t-0" cellspacing="0">
                    <thead>
                        <tr>
                        {{-- Table columns --}}
                        @foreach ($crud->columns as $column)
                            <th
                            data-orderable="{{ var_export($column['orderable'], true) }}"
                            data-priority="{{ $column['priority'] }}"
                            data-visible-in-modal="{{ (isset($column['visibleInModal']) && $column['visibleInModal'] == false) ? 'false' : 'true' }}"
                            data-visible="{{ !isset($column['visibleInTable']) ? 'true' : (($column['visibleInTable'] == false) ? 'false' : 'true') }}"
                            data-visible-in-export="{{ (isset($column['visibleInExport']) && $column['visibleInExport'] == false) ? 'false' : 'true' }}"
                            >
                            {!! $column['label'] !!}
                            </th>
                        @endforeach

                        @if ( $crud->buttons->where('stack', 'line')->count() )
                            <th data-orderable="false" data-priority="{{ $crud->getActionsColumnPriority() }}" data-visible-in-export="false">{{ trans('backpack::crud.actions') }}</th>
                        @endif
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                        {{-- Table columns --}}
                        @foreach ($crud->columns as $column)
                            <th>{!! $column['label'] !!}</th>
                        @endforeach

                        @if ( $crud->buttons->where('stack', 'line')->count() )
                            <th>{{ trans('backpack::crud.actions') }}</th>
                        @endif
                        </tr>
                    </tfoot>
                    </table>

                    @if ( $crud->buttons->where('stack', 'bottom')->count() )
                    <div id="bottom_buttons" class="hidden-print">
                    @include('crud::inc.button_stack', ['stack' => 'bottom'])

                    <div id="datatable_button_stack" class="pull-right text-right hidden-xs"></div>
                    </div>
                    @endif
                </div>
            </div>
        </div><!-- /.box-body -->

      </div><!-- /.box -->
    </div>

  </div>

@endsection

@section('after_styles')
  <!-- DATA TABLES -->
  <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">

  <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/list.css') }}">

  <!-- CRUD LIST CONTENT - crud_list_styles stack -->
  @stack('crud_list_styles')
  @stack('crud_fields_styles')
@endsection

@section('after_scripts')
	@include('crud::inc.datatables_logic')

  <script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
  <script src="{{ asset('vendor/backpack/crud/js/form.js') }}"></script>
  <script src="{{ asset('vendor/backpack/crud/js/list.js') }}"></script>
  <script src="{{ asset('vendor/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
  <script>
      if (jQuery.ui) {
          var datepicker = $.fn.datepicker.noConflict();
          $.fn.bootstrapDP = datepicker;
      } else {
          $.fn.bootstrapDP = $.fn.datepicker;
      }

      var dateFormat=function(){var a=/d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,b=/\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,c=/[^-+\dA-Z]/g,d=function(a,b){for(a=String(a),b=b||2;a.length<b;)a="0"+a;return a};return function(e,f,g){var h=dateFormat;if(1!=arguments.length||"[object String]"!=Object.prototype.toString.call(e)||/\d/.test(e)||(f=e,e=void 0),e=e?new Date(e):new Date,isNaN(e))throw SyntaxError("invalid date");f=String(h.masks[f]||f||h.masks.default),"UTC:"==f.slice(0,4)&&(f=f.slice(4),g=!0);var i=g?"getUTC":"get",j=e[i+"Date"](),k=e[i+"Day"](),l=e[i+"Month"](),m=e[i+"FullYear"](),n=e[i+"Hours"](),o=e[i+"Minutes"](),p=e[i+"Seconds"](),q=e[i+"Milliseconds"](),r=g?0:e.getTimezoneOffset(),s={d:j,dd:d(j),ddd:h.i18n.dayNames[k],dddd:h.i18n.dayNames[k+7],m:l+1,mm:d(l+1),mmm:h.i18n.monthNames[l],mmmm:h.i18n.monthNames[l+12],yy:String(m).slice(2),yyyy:m,h:n%12||12,hh:d(n%12||12),H:n,HH:d(n),M:o,MM:d(o),s:p,ss:d(p),l:d(q,3),L:d(q>99?Math.round(q/10):q),t:n<12?"a":"p",tt:n<12?"am":"pm",T:n<12?"A":"P",TT:n<12?"AM":"PM",Z:g?"UTC":(String(e).match(b)||[""]).pop().replace(c,""),o:(r>0?"-":"+")+d(100*Math.floor(Math.abs(r)/60)+Math.abs(r)%60,4),S:["th","st","nd","rd"][j%10>3?0:(j%100-j%10!=10)*j%10]};return f.replace(a,function(a){return a in s?s[a]:a.slice(1,a.length-1)})}}();dateFormat.masks={default:"ddd mmm dd yyyy HH:MM:ss",shortDate:"m/d/yy",mediumDate:"mmm d, yyyy",longDate:"mmmm d, yyyy",fullDate:"dddd, mmmm d, yyyy",shortTime:"h:MM TT",mediumTime:"h:MM:ss TT",longTime:"h:MM:ss TT Z",isoDate:"yyyy-mm-dd",isoTime:"HH:MM:ss",isoDateTime:"yyyy-mm-dd'T'HH:MM:ss",isoUtcDateTime:"UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"},dateFormat.i18n={dayNames:["Sun","Mon","Tue","Wed","Thu","Fri","Sat","Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],monthNames:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","January","February","March","April","May","June","July","August","September","October","November","December"]},Date.prototype.format=function(a,b){return dateFormat(this,a,b)};

      jQuery(document).ready(function($){
          $('[data-bs-datepicker]').each(function(){

              var $fake = $(this),
              $field = $fake.parents('.form-group').find('input[type="hidden"]'),
              $customConfig = $.extend({
                  format: 'dd/mm/yyyy'
              }, $fake.data('bs-datepicker'));
              $picker = $fake.bootstrapDP($customConfig);

              var $existingVal = $field.val();

              if( $existingVal.length ){
                  // Passing an ISO-8601 date string (YYYY-MM-DD) to the Date constructor results in
                  // varying behavior across browsers. Splitting and passing in parts of the date
                  // manually gives us more defined behavior.
                  // See https://stackoverflow.com/questions/2587345/why-does-date-parse-give-incorrect-results
                  var parts = $existingVal.split('-')
                  var year = parts[0]
                  var month = parts[1] - 1 // Date constructor expects a zero-indexed month
                  var day = parts[2]
                  preparedDate = new Date(year, month, day).format($customConfig.format);
                  $fake.val(preparedDate);
                  $picker.bootstrapDP('update', preparedDate);
              }

              $fake.on('keydown', function(e){
                  e.preventDefault();
                  return false;
              });

              $picker.on('show hide change', function(e){
                  if( e.date ){
                      var sqlDate = e.format('yyyy-mm-dd');
                  } else {
                      try {
                          var sqlDate = $fake.val();

                          if( $customConfig.format === 'dd/mm/yyyy' ){
                              sqlDate = new Date(sqlDate.split('/')[2], sqlDate.split('/')[1] - 1, sqlDate.split('/')[0]).format('yyyy-mm-dd');
                          }
                      } catch(e){
                          if( $fake.val() ){
                              PNotify.removeAll();
                              new PNotify({
                                  title: 'Whoops!',
                                  text: 'Sorry we did not recognise that date format, please make sure it uses a yyyy mm dd combination',
                                  type: 'error',
                                  icon: false
                              });
                          }
                      }
                  }

                  $field.val(sqlDate);
              });
          });
      });
      @if ($crud->inlineErrorsEnabled() && $errors->any())

        $('div.box-info').removeClass('collapsed-box');

        window.errors = {!! json_encode($errors->messages()) !!};
        // console.error(window.errors);

        $.each(errors, function(property, messages){

            var normalizedProperty = property.split('.').map(function(item, index){
                    return index === 0 ? item : '['+item+']';
                }).join('');

            var field = $('[name="' + normalizedProperty + '[]"]').length ?
                        $('[name="' + normalizedProperty + '[]"]') :
                        $('[name="' + normalizedProperty + '"]'),
                        container = field.parents('.form-group');

            container.addClass('has-error');

            $.each(messages, function(key, msg){
                // highlight the input that errored
                var row = $('<div class="help-block">' + msg + '</div>');
                row.appendTo(container);

                // highlight its parent tab
                @if ($crud->tabsEnabled())
                var tab_id = $(container).parent().attr('id');
                $("#form_tabs [aria-controls="+tab_id+"]").addClass('text-red');
                @endif
            });
        });

      @endif
  </script>

  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
  @stack('crud_fields_scripts')
@endsection
