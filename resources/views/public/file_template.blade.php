<div id="file{NUMBER}">
<div class="form-group">
        <label for="file_name{NUMBER}">{{Lang::get('app.file')}} {NUMBER}</label>
        <input type="text" 
               name="files[{NUMBER}][name]" 
               class="form-control" 
               id="file_name{NUMBER}" 
               placeholder="{{Lang::get('app.file_name')}} {NUMBER}">
    </div>
    <div class="form-group">
        <label for="file_data{NUMBER}">{{Lang::get('app.code')}}</label>
        <textarea class="form-control" 
                  name="files[{NUMBER}][data]" 
                  id="file_data{NUMBER}" 
            rows="6"></textarea>
    </div>
</div>