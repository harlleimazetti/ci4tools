<div class="form-group">
  <label class="form-label" for="single-default">
    {{label}}
  </label>
  {{# options}}
    <div class="custom-control custom-radio mb-2">
      <input type="radio" class="custom-control-input" name="{{name}}" id="{{name}}[{{value}}]" value="{{value}}" <?php if (${{table}}->{{name}} == {{value}}) { ?> checked <?php } ?>>
      <label class="custom-control-label" for="{{name}}[{{value}}]">{{text}}</label>
    </div>
  {{/ options}}
  {{^ options}}
    {{# foreign_table_name}}
      <?php
        foreach(${{foreign_table_name}}s as ${{foreign_table_name}}) {
          $text = "";
          {{# foreign_column_show}}
          $text .= ${{foreign_table_name}}->{{.}}." - ";
          {{/ foreign_column_show}}
          $text = substr($text, 0, -3);
      ?>
      <div class="custom-control custom-radio mb-1">
        <input type="radio" class="custom-control-input" name="{{name}}" id="{{name}}<?php echo ${{foreign_table_name}}->{{foreign_column_name}} ?>" <?php if (!empty(${{table}}->{{name}})) { ?> checked <?php } ?>>
        <label class="custom-control-label" for="{{name}}<?php echo ${{foreign_table_name}}->{{foreign_column_name}} ?>"><?php echo $text ?></label>
      </div>
      <?php } ?>  
    {{/ foreign_table_name}}
    {{^ foreign_table_name}}
      <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" name="{{name}}" id="{{name}}" <?php echo ${{table}}->{{name}} ?>" <?php if (!empty(${{table}}->{{name}})) { ?> checked <?php } ?>>
        <label class="custom-control-label" for="{{name}}">{{label}}</label>
      </div>
    {{/ foreign_table_name}}
  {{/ options}}
</div>