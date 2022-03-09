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
    <div class="custom-control custom-radio">
      <input type="radio" class="custom-control-input" name="{{name}}" id="{{name}}" <?php echo ${{table}}->{{name}} ?>" <?php if (!empty(${{table}}->{{name}})) { ?> checked <?php } ?>>
      <label class="custom-control-label" for="{{name}}">{{label}}</label>
    </div>
  {{/ options}}
</div>