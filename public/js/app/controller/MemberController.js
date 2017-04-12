toastr.options = {
	"closeButton": false,
	"debug": false,
	"newestOnTop": false,
	"progressBar": false,
	"positionClass": "toast-top-right",
	"preventDuplicates": false,
	"onclick": null,
	"showDuration": "300",
	"hideDuration": "1000",
	"timeOut": "5000",
	"extendedTimeOut": "1000",
	"showEasing": "swing",
	"hideEasing": "linear",
	"showMethod": "fadeIn",
	"hideMethod": "fadeOut"
};

jQuery.validator.addMethod("uploadFile", function (val, element) {

      var size = element.files[0].size;
        console.log(size);

       if (size > 1073741824)// checks the file more than 10 MB
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
app.controller ('MemberController', function($scope, $http, API) {
	$scope.sortType = "name";
	$scope.sortReverse =false;
	$scope.NumAge =/^[1-9]{2}$/;

	$http({
		method : 'GET',
		url :'list',
	}).then(function(response){
		$scope.members = response.data;
	});

	$scope.add = function() {
		$('#myModalAdd').modal('show');
		$scope.frmTitle = "Thêm Thành Viên";
	};

	$scope.edit = function (id) {
		$('#myModalEdit').modal('show');
		$scope.frmTitle = "Sửa Thành Viên";
		$scope.id  = id;
		$http({
			method : 'GET',
			url : 'edit/' + id,
		}).then(function(response) {
			$scope.Member = response.data;
		});
	};


	$('#formMemberAdd').validate({
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
		submitHandler: function(form){
			alert('ok');
		}
	});
});
