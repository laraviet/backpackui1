<input type="hidden" name="http_referrer" value={{ url($crud->route) }}>

<div class="col-md-12 padding-10 p-t-20">
    @include('crud::inc.show_fields', ['fields' => $fields])
</div>

{{-- Define blade stacks so css and js can be pushed from the fields to these sections. --}}
