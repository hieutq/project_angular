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

app.controller('MemberController', function ($scope, $http, API) {
    $scope.sortType = 'name'; // set the default sort type
    $scope.sortReverse = false;  // set the default sort order
    $scope.NumAge = /^[0-9]{2}$/;
    $scope.NameCharacter = /[^0-9|'| _]+\w/;
    $scope.Member = {};
    $http({
        method: 'GET',
        url: 'list',
    }).then(function (response) {
        $scope.members = response.data;
    });

    $scope.modal = function (state, id) {
        $scope.state = state
        switch (state) {
            case "add" :
                document.getElementById("imgThumbnail").src = "";
                $scope.Member = {};
                $scope.files = "";
                $('.error').removeClass('active');
                $('.error').addClass('disactive');
                $('#myModalAdd').modal('show');
                $scope.frmTitle = " Thêm Thành Viên";
                break;
            case "edit" :
                document.getElementById("imageID").src = "";
                $('.error').removeClass('active')
                $('.error').addClass('disactive');
                $('#myModalEdit').modal('show');
                $scope.id = id;
                $http({
                    method: 'get',
                    url: 'edit/' + id,
                }).then(function (response) {
                    $scope.MemberEdit = response.data;
                    $scope.image = response.data.photo;
                });
                $scope.frmTitle = "Sửa Thành Viên";
                break;
            default :
                $scope.frmTitle = " Thành Viên";
                break;
        }
    };

    $scope.save = function (state, id) {
        if (state == 'add') {
            if ($scope.formAdd.$invalid == false) {
                $http({
                method: 'POST',
                url: 'add',
                headers: {'Content-Type': undefined},
                data: {
                    name: $scope.Member.name,
                    gender: $scope.Member.gender,
                    address: $scope.Member.address,
                    age: $scope.Member.age,
                    photo: $scope.files
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
            }).then(function (response) {               
                    $http({
                        method: 'GET',
                        url: 'list',
                    }).then(function (response) {
                        console.log(response);
                        $scope.members = response.data;
                    });
                    $('#formMemberAdd').trigger("reset");
                    $('#myModalAdd').modal('hide');

                    toastr["success"]("Thêm thành viên thành công!");
                  }, function (response) {
                    console.log(response);
                  });
            }    
            
        } else if (state == 'edit') {
            if ($scope.formEdit.$invalid == false) {
                $http({
                    method: 'POST',
                    url: 'edit/' + id,
                    headers: {'Content-Type': undefined},
                    data: {
                        name: $scope.MemberEdit.name,
                        gender: $scope.MemberEdit.gender,
                        address: $scope.MemberEdit.address,
                        age: $scope.MemberEdit.age,
                        photo: $scope.files
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
                }).then(function (response) {
                    if (response.data.error == false) {
                        console.log(response);
                        $('.error').removeClass('disactive');
                        $('.error').show().addClass('active');
                        $scope.messagesErrorimage = response.data.messages.photo[0];
                        $scope.messagesName = response.data.messages.name[0];
                        $scope.messagesGender = response.data.messages.gender[0];
                        $scope.messagesAge = response.data.messages.age[0];
                    }
                    else {
                        $http({
                            method: 'GET',
                            url: 'list',
                        }).then(function (response) {
                            $scope.members = response.data;
                        });
                        $('#myModalEdit').modal('hide');
                        toastr["success"]("Sửa thành viên thành công!");

                    }
                }, function (response) {
                    toastr["error"]("Đã xảy ra lỗi vui lòng kiểm tra lại !");
                });
            }
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
            function (isConfirm) {
                if (isConfirm) {
                    $http({
                        method: 'delete',
                        url: 'delete/' + id,
                    }).then(function (response) {
                        toastr["success"]("Xóa thành viên thành công!");
                        $http({
                            method: 'GET',
                            url: 'list',
                        }).then(function (response) {
                            $scope.members = response.data;
                        });
                    }, function (response) {

                        toastr["error"]("Đã xảy ra lỗi vui lòng kiểm tra lại !");
                    });
                } else {
                    toastr["warning"]("Thao tác đã bị hủy !");
                }
            });
    }
    /*reset Form*/
    $scope.resetForm = function () {
        $scope.Member = {};
    }

    $scope.imageUpload = function (event) {
        var files = event.target.files;
        var file = files[files.length - 1];
        $scope.file = file;
        var reader = new FileReader();
        reader.onload = $scope.imageIsLoaded;
        reader.readAsDataURL(file);
    }


    $scope.imageIsLoaded = function (e) {
        $scope.$apply(function () {
            $scope.step = e.target.result;
        })
    }
    $scope.uploadImage = function (files) {
        var ext = files[0].name.match(/\.(.+)$/)[1];
        if (angular.lowercase(ext) === 'jpg' || angular.lowercase(ext) === 'jpeg' || angular.lowercase(ext) === 'png') {
            var image = files[0].size;
            if (image > 10485760) {
                $('#formMemberEdit button[type="submit"]').prop('disabled', true);
                $('.error').removeClass('disactive');
                $('.error').addClass('active');
                $scope.messagesErrorimage = 'The photo may not be greater than 10 MB.';
            } else {
                $('.error').removeClass('active');
                $('.error').addClass('disactive');
                $('#formMemberEdit button[type="submit"]').prop('disabled', false);
            }
        } else {
            $('.error').removeClass('disactive');
            $('.error').addClass('active');
            $scope.messagesErrorimage = 'The photo must be a file of type: jpeg, png, gif.';
            $('#formMemberEdit button[type="submit"]').prop('disabled', true);
        }
    }
});