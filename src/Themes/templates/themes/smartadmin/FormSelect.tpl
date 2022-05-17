<div class="form-group">
  <label class="form-label" for="single-default">
    {{label}}
  </label>
  {{# foreign_table_name}}
  <select class="select2 form-control w-100" name="{{name}}" id="{{name}}" data-ajax--url="<?php echo base_url('/sistema/{{foreign_table_name}}/searchSelect2') ?>" data-ajax--data-type="json" data-ajax--type="post" data-ajax--delay="250">
  {{/ foreign_table_name}}
  {{^ foreign_table_name}}
  <select class="select2 form-control w-100" name="{{name}}" id="{{name}}">
  {{/ foreign_table_name}}
    {{# options}}
    <option value="{{value}}" <?php if (${{table}}->{{name}} == {{value}}) { ?>selected<?php } ?>>{{text}}</option>
    {{/ options}}
  </select>
</div>