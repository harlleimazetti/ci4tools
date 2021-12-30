<div class="form-group">
  <span class="file-upload btn btn-primary">
    <span class="fal fa-upload mr-1"></span>
    {{label}}
    <input type="file" name="files[]" id="files[]" multiple style="position: absolute; top:0; left: 0; width: 100% !important; height: 100% !important; opacity: 0; cursor: pointer !important;">
  </span>
  <div class="progress progress-sm mt-2" id="file-upload-progress">
    <div class="progress-bar bg-primary-300 bg-primary-gradient" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
  </div>
  <div id="file-upload-list"></div>
</div>