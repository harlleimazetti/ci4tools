<div class="form-group">
  <div class="custom-control custom-checkbox">
    <input type="checkbox" class="custom-control-input" name="{{name}}" id="{{name}}" value="<?php echo ${{table}}->{{name}} ?>" <?php if (!empty(${{table}}->{{name}})) { ?> checked <?php } ?>>
    <label class="custom-control-label" for="{{name}}">{{label}}</label>
  </div>
</div>