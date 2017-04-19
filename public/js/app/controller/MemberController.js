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

app.controller ('MemberController' ,function($scope, $http, API) {
	$scope.sortType     = 'name'; // set the default sort type
  	$scope.sortReverse  = false;  // set the default sort order
  	$scope.NumAge = /^[0-9]{2}$/;
  	$scope.NameCharacter = /[^0-9]+\D/;
	$http({
		method: 'GET',
		url:'list',
	}).then(function (response){
		$scope.members = response.data;
	},function (response){

	});

	$scope.modal = function (state,id) {
		$scope.state = state
		switch(state) {
			case "add" :  
				$scope.Member = {};
				$('.error').hide();
				$('#myModalAdd').modal('show');
				$scope.frmTitle = " Thêm Thành Viên";
				break;
			case "edit" : 
				$('.error').removeClass('active')	
				$('.error').hide().addClass('disactive');
				$('#myModalEdit').modal('show');
				$scope.id = id;
				$http({
					method : 'get',
					url :'edit/'+ id,
				}).then(function(response){
					$scope.MemberEdit = response.data;
					$scope.image = response.data.photo;
				});
				$scope.frmTitle = "Sửa Thành Viên";
				break;
			default : $scope.frmTitle = " Thành Viên";
				break;
		}
	};
	
	$scope.save = function ( state,id ) {
		if (state =='add') {
			$http({
	            method: 'POST',
	            url: 'add',
	            headers: {'Content-Type': undefined},
	            data: {
	                name: $scope.Member.name,
	                gender: $scope.Member.gender,
	                address: $scope.Member.address,
	                age: $scope.Member.age,
	                photo: $scope.Member.files
	            },
	            transformRequest: function (data, headersGetter) {
	                var fd = new FormData();
	                angular.forEach(data, function (value, key) {
	                    fd.append(key, value);
	                });
	                var headers = headersGetter();
	                delete headers['Content-Type'];
	                return fd;
	            }
	        }).then(function(response){

	            if (response.data.error) {
	            	$('.error').show();
	            	$scope.messagesError 	= response.data.messages.photo;
	            	$scope.messagesName 	= response.data.messages.name;
	            	$scope.messagesGender 	= response.data.messages.gender;
	            	$scope.messagesAge 		= response.data.messages.age;

	            }
	            else{
	            	$scope.members = response.data;
	            	$('#formMemberAdd').trigger("reset");
	            	$('#myModalAdd').modal('hide');
	            	
	            	toastr["success"]("Thêm thành viên thành công!");
	            	
	            }
	        });
		}else if (state == 'edit') {
			$http({
	            method: 'POST',
	            url: 'edit/' + id,
	            headers: {'Content-Type': undefined},
	            data: {
	                name: $scope.MemberEdit.name,
	                gender: $scope.MemberEdit.gender,
	                address: $scope.MemberEdit.address,
	                age: $scope.MemberEdit.age,
	                photo: $scope.MemberEdit.files
	            },
	            transformRequest: function (data, headersGetter) {
	                var fd = new FormData();
	                angular.forEach(data, function (value, key) {
	                    fd.append(key, value);
	                });
	                var headers = headersGetter();
	                delete headers['Content-Type'];
	                return fd;
	            }
	        }).then(function(response){
	        	
	            if (response.data.error ) {
	            	$('.error').show();
	            	$scope.messagesError 	= response.data.message.photo;
	            	$scope.messagesName 	= response.data.message.name;
	            	$scope.messagesGender 	= response.data.message.gender;
	            	$scope.messagesAge 		= response.data.message.age;
	            }
	            else{
	            	$scope.members = response.data;
	            	$('#myModalEdit').modal('hide');
	            	toastr["success"]("Sửa thành viên thành công!");
	            	
	            }
	        },function(response) {
				toastr["error"]("Đã xảy ra lỗi vui lòng kiểm tra lại !");
			});
		}
	}

	$scope.confirmDelete = function (id) {
		swal({
		    title: "Are you sure?",
			text: "You will not be able to recover this imaginary file!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "No, cancel plx!",
			closeOnConfirm: true,
			closeOnCancel: true
		},
		function(isConfirm){
			if (isConfirm) {
				$http({
					method : 'delete',
					url : 'delete/' + id,
				}).then(function(response){
					toastr["success"]("Xóa thành viên thành công!");
					$scope.members = response.data
				},function(response){

					toastr["error"]("Đã xảy ra lỗi vui lòng kiểm tra lại !");
				});
			} else {
				toastr["warning"]("Thao tác đã bị hủy !");
			}
		});
	}

	$scope.resetForm = function () {
		$scope.Member = {};
	}
    $scope.imageUpload = function(event){

        var files = event.target.files;
        var file = files[files.length-1];
        $scope.file = file;
        var reader = new FileReader();
        reader.onload = $scope.imageIsLoaded;
        reader.readAsDataURL(file);
    }



    $scope.imageIsLoaded = function(e){
        $scope.$apply(function(){
            $scope.step = e.target.result;
        })
    }
    $scope.uploadImage = function (files) {           
       var ext = files[0].name.match(/\.(.+)$/)[1];
       if(angular.lowercase(ext) ==='jpg' || angular.lowercase(ext) ==='jpeg' || angular.lowercase(ext) ==='png'){
       		var image = files[0].size;
       		if (image > 10*1024*1024) {
       			$('.error').removeClass('disactive');
       			$('.error').show().addClass('active');
       			$scope.messagesErrorimage= 'The photo may not be greater than 10 MB.';

       			$('#formMemberEdit button[type="submit"]').prop('disabled',true);
       		}
       		else{
       			$('.error').hide();
       			$('#formMemberEdit button[type="submit"]').prop('disabled',false);
       		}
       		$('.error').hide();
       		$('#formMemberEdit button[type="submit"]').prop('disabled',false);
       }  
       else{
       	$('.hieuit').show().addClass('active');
        $scope.messagesErrorimage 	= 'The photo must be a file of type: jpeg, png, gif.';
        $('#formMemberEdit button[type="submit"]').prop('disabled',true);
       }       
    }
});