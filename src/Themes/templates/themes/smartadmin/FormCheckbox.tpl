<div class="form-group">
  <label class="form-label" for="single-default">
    {{label}}
  </label>
  {{# options}}
    <div class="custom-control custom-checkbox mb-2">
      <input type="checkbox" class="custom-control-input" name="{{name}}[]" id="{{name}}[{{value}}]" value="{{value}}" <?php if (${{table}}->{{name}} == {{value}}) { ?> checked <?php } ?>>
      <label class="custom-control-label" for="{{name}}[{{value}}]">{{text}}</label>
    </div>
  {{/ options}}
  {{^ options}}
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input" name="{{name}}" id="{{name}}" value="<?php echo ${{table}}->{{name}} ?>" <?php if (!empty(${{table}}->{{name}})) { ?> checked <?php } ?>>
      <label class="custom-control-label" for="{{name}}">{{label}}</label>
    </div>
  {{/ options}}
</div>