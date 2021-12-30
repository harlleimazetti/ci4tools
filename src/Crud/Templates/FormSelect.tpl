<div class="form-group">
  <label class="form-label" for="single-default">
    {{label}}
  </label>
  <select class="select2 form-control w-100" name="{{name}}" id="{{name}}">
    {{# options}}
      <option value="{{value}}" <?php if (${{table}}->{{name}} == {{value}}) { ?>selected<?php } ?>>{{text}}</option>
    {{/ options}}
  </select>
</div>