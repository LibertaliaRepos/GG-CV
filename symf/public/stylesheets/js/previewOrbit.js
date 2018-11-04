var input = $('#project_images');


$(input).change(loadPreview);
$(document).ready(function() {
  input.trigger('change');
})


function loadPreview() {
  console.log('toto');
  
  var images = '';
  var files = this.files;
  var j = 0;
  
  if(files) {
    for (var i = 0; i < files.length; ++i) {
      
      var reader = new FileReader();
      reader.onload = function(e) {
        images += '<img src="' + e.target.result + '" data-img-preview="' + j + '" />';
        j++;
        $('#preview').html(images);
      }
      
      reader.readAsDataURL(files[i]);
    }
  }
}