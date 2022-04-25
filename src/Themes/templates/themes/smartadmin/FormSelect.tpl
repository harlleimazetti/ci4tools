<div class="form-group">
  <label class="form-label" for="single-default">
    {{label}}
  </label>
  <select class="select2 form-control w-100" name="{{name}}" id="{{name}}">
    {{# options}}
      <option value="{{value}}" <?php if (${{table}}->{{name}} == {{value}}) { ?>selected<?php } ?>>{{text}}</option>
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
        <option value="<?php echo ${{foreign_table_name}}->{{foreign_column_name}} ?>"><?php echo $text ?></option>
        <?php } ?>  
      {{/ foreign_table_name}}
    {{/ options}}
  </select>
</div>