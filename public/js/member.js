$(function(){
	jQuery.validator.addMethod("uploadFile", function (val, element) {

          var size = element.files[0].size;
            console.log(size);

           if (size > 1073741824)// checks the file more than 1 MB
           {
               console.log("returning false");
                return false;
           } else {
               console.log("returning true");
               return true;
           }
    }, "File type error");

    jQuery.validator.addMethod("laxEmail", function(extension , element) {
  // allow any non-whitespace characters as the host part
	  return this.optional( element ) || /\.(jpe?g|gif|png)$/i.test( value );
	}, 'Please enter a valid email address.');

	$('#formMember').validate({
		errorElement : "span",
		rule : {
			photo :{
				required: true,
				uploadFile: true,
                extension:true,
			}
		},
		messages : {
			photo :{
				required:'you select images',
				required: 'Dung Lượng ảnh không quá 10MB',
                accept:'Định dạng ảnh không đúng'
			}
		},
	});
});