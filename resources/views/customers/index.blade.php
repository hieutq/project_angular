@extends ('layouts.master')

@section('head')
	<style type="text/css" media="screen">
		.colorMessages {
			color: red;
		}
		.error {
			color: red;
		}
		.imge {
			border-radius: 4px;
		}
		.active {
			display: inline!important;
		}
		.disactive{
			display: none!important;
		}
	</style>
@endsection

@section ('contents')
<div class="portlet light bordered" ng-app="my-app">
	<div class="row" ng-controller="MemberController">
	   <div class="portlet-title">
	      <div class="caption uppercase">
	         <i class="fa fa-users"></i> Danh Sách Khách Hàng 
	      </div>
	   </div>
	   <div class="row">
	      <div class="col-xs-12 col-sm-4 col-md-6 col-lg-5">
	         <button class="btn green btn-circle" ng-click="modal('add')"><i class="fa fa-plus" ></i> Thêm mới</button>
	      </div>
	      <div class="col-xs-12 col-sm-8 col-md-6 col-lg-7">
	         <form method="get" action="">
	            <input type="text" class="search-class form-control" id="search"  name="search"  placeholder="Nhập Thông Tin Tìm Kiếm">
	         </form>
	      </div>
	   </div>
		
	   <div class="portlet-body">
	      <div class="table-scrollable">
	         <table class="table table-striped table-bordered table-hover">
	            <thead>
	               <tr>
	                  	<th class="stl-column color-column">#</th>
						<th class="stl-column color-column">Avatar</th>
						<th class="stl-column color-column" ng-click="sortType = 'name'; sortReverse = !sortReverse">Tên
							<span ng-show="sortType == 'name' && !sortReverse" class="fa fa-caret-down"></span>
							<span ng-show="sortType == 'name' && sortReverse" class="fa fa-caret-up"></span>
						</th>
						<th class="stl-column color-column">Giới Tính</th>
						<th class="stl-column color-column" ng-click="sortType = 'age'; sortReverse = !sortReverse">Tuổi
							<span ng-show="sortType == 'age' && !sortReverse" class="fa fa-caret-down"></span>
							<span ng-show="sortType == 'age' && sortReverse" class="fa fa-caret-up"></span>
						</th>
						<th class="stl-column color-column" ng-click="sortType = 'address'; sortReverse = !sortReverse">Địa Chỉ
							<span ng-show="sortType == 'address' && !sortReverse" class="fa fa-caret-down"></span>
							<span ng-show="sortType == 'address' && sortReverse" class="fa fa-caret-up"></span>
						</th>

						<th class="stl-column color-column">Hành động</th>
	               </tr>
	            </thead>
	            <tbody>
	               
	               <tr  ng-repeat="db in members | orderBy:sortType:sortReverse">
	                  	<td class="text-center">@{{ db.id }}</td>
	                  	<td class="text-center"><img ng-src="{{asset('images')}}/@{{db.photo }}" class="imge" height="150" width="150" alt=""></td>
	                  	<td class="text-center">@{{ db.name }}</td>
	                  	<td class="text-center" ng-if="db.gender==1">Nam</td>
	                  	<td class="text-center" ng-if="db.gender==0">Nữ</td>
	                  	<td class="text-center">@{{ db.age }}</td>
	                  	<td class="text-center">@{{ db.address }}</td>            
	                  	<td class="text-center">
	                     	<a href="#" class="btn btn-outline btn-circle green btn-sm purple idEdit"   ng-click="modal('edit',db.id)">
	                     		<i class="fa fa-list" aria-hidden="true"></i> Sửa
	                     	</a>
							<a href="#" type="submit" class="btn btn-outline btn-circle dark btn-sm red" ng-click="confirmDelete(db.id)">
								<i class="fa fa-trash-o"></i> Xóa 
							</a>
	                  	</td>

	               </tr>
	            </tbody>
	         </table>
	      </div>
	   </div>
	
		<div class="modal fade" id="myModalAdd" role="dialog" >
		   <div class="modal-dialog">
		      <!-- Modal content-->
		      <div class="modal-content">
		         <div class="modal-header">
		            <h4 style="color:red;"></span>@{{ frmTitle }}</h4>
		         </div>
		         <div class="modal-body">
		            <form role="form" name="formAdd" id="formMemberAdd" novalidate enctype="multipart/form-data">
		               <div class="form-group">
							<label for="usrname"></span> Name</label>
							<input type="text" class="form-control " ng-pattern="NameCharacter" name="name" ng-model="Member.name" ng-required="true"  id="usrname" placeholder="Enter Your Name" ng-required="true" ng-maxlength="100" >
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<p class="font-red-mint error">@{{ messagesName }}</p>
			                <div ng-show="formAdd.$submitted || formAdd.name.$touched">
						    <span class="colorMessages" ng-show="formAdd.name.$error.required">Tell us your name.</span>
						    <span class="colorMessages" ng-show="formAdd.name.$error.pattern">The name must be characters</span>
						    <span class="colorMessages" ng-show="formAdd.name.$invalid">The name may not be greater than 100 characters.</span>
						    </div>

		               </div>
		               <div class="form-group">
		                  	<label for="psw"> Gender </label>
							<select name="gender" ng-model="Member.gender" class="form-control" ng-required="true">
								<option value="">--Chọn--</option>}
								<option value="1" ng-selected="Member.gender == 1">Nam</option>
								<option value="0" ng-selected="Member.gender == 0">Nữ</option>
							</select>
							<p class="font-red-mint error">@{{ messagesGender }}</p>
		                   	<div ng-show="formAdd.$submitted || formAdd.gender.$touched">
						        <span class="colorMessages" ng-show="formAdd.gender.$error.required">Tell us your gender.</span>
						    </div>
		               </div>

		               <div class="form-group">
		                  	<label for="psw"> Age</label>
		                  	<input type="text" class="form-control" ng-pattern="NumAge" name="age" id="age" ng-model="Member.age" placeholder="Enter Age" ng-required="true">
		                  	<p class="font-red-mint error">@{{ messagesAge }}</p>
		                  	 <div ng-show="formAdd.$submitted || formAdd.age.$touched">
						        <span class="colorMessages" ng-show="formAdd.age.$error.required">Tell us your age.</span>
						        <span class="colorMessages" ng-show="formAdd.age.$error.pattern">Your age must be a number and a 2 digit number</span>
						    </div>
		               </div>
		               <div class="form-group">
		                  <label for="psw"> Address</label>
		                  
		                  <textarea name="address" class="form-control" ng-model="Member.address" ng-maxlength='300' id="address" ng-required='true'></textarea>
		                  	<div ng-show="formAdd.$submitted || formAdd.address.$touched">
						        <span class="colorMessages" ng-show="formAdd.address.$error.required">Tell us your address. </span>
						        <span class="colorMessages" ng-show="formAdd.address.$invalid">The address may not be greater than 300 characters.</span>
						    </div>
		                  
		               </div>
		               <div class="form-group">
		                  	<label for="psw"> Avatar</label>
		                  	<div class="form-group" >
                                <input type="file" file-model="Member.files" id="upload" onchange="angular.element(this).scope().imageUpload(event)" />
                            </div>
                            <div class="form-group" >
                                <img class="img-thumbnail" style="width:100px;height:80px;" ng-src="@{{step}}" />
                            </div>
		                  <p class="font-red-mint error">@{{ messagesError }}</p>
		               </div>
		               	<button type="submit" class=" btn btn-default btn-success btn-block" ng-click="save(state,id)" ng-disabled="formAdd.$invalid"><span class="glyphicon glyphicon-off"></span> Thêm</button>
		                <button type="submit" class="btn btn-default btn-success btn-block"  ng-click="resetForm()"><span class="glyphicon glyphicon-repeat"></span> reset</button>
		            </form>
		         </div>
		      </div>
		   </div>
		</div> 
		<div class="modal fade" id="myModalEdit" role="dialog" >
		   <div class="modal-dialog">
		      <!-- Modal content-->
		      <div class="modal-content">
		         <div class="modal-header">
		            <h4 style="color:red;"></span>@{{ frmTitle }}</h4>
		         </div>
		         <div class="modal-body">
		            <form role="form" name="formEdit" id="formMemberEdit" novalidate enctype="multipart/form-data">
		               <div class="form-group">
							<label for="usrname"></span> Name</label>
							<input type="text" class="form-control " name="name" ng-pattern="NameCharacter" ng-model="MemberEdit.name" ng-required="true"  id="usrname" placeholder="Enter Your Name" ng-required="true" ng-maxlength='100'>
							<input type="hidden" class="form-control " name="id" ng-model="MemberEdit.id" ng-required="true" value="@{{id}}" placeholder="Enter Your Name" ng-required="true">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<p class="font-red-mint error">@{{ messagesName }}</p>
			                <div ng-show="formEdit.$submitted || formEdit.name.$touched">
						    <span class="colorMessages" ng-show="formEdit.name.$error.required">Tell us your name.</span>
						    <span class="colorMessages" ng-show="formEdit.name.$error.pattern">The name must be characters</span>
						    <span class="colorMessages" ng-show="formEdit.name.$invalid">The name may not be greater than 100 characters.</span>

						    </div>

		               </div>
		               <div class="form-group">
		                  	<label for="psw"> Gender </label>
							<select name="gender" ng-model="MemberEdit.gender" class="form-control" ng-required="true">
								<option value="">--Chọn--</option>}
								<option value="1" ng-selected="MemberEdit.gender == 1">Nam</option>
								<option value="0" ng-selected="MemberEdit.gender == 0">Nữ</option>
							</select>
							<p class="font-red-mint error">@{{ messagesGender }}</p>
		                   	<div ng-show="formEdit.$submitted || formEdit.gender.$touched">
						        <span class="colorMessages" ng-show="formEdit.gender.$error.required">Tell us your gender.</span>
						    </div>
		               </div>

		               <div class="form-group">
		                  	<label for="psw"> Age</label>
		                  	<input type="text" class="form-control" ng-pattern="NumAge" name="age" id="age" ng-model="MemberEdit.age" placeholder="Enter Age" ng-required="true">
		                  	 <p class="font-red-mint error">@{{ messagesAge }}</p>
		                  	 <div ng-show="formEdit.$submitted || formEdit.age.$touched">
						        <span class="colorMessages" ng-show="formEdit.age.$error.required">Tell us your age.</span>
						        <span class="colorMessages" ng-show="formEdit.age.$error.pattern">Your age must be a number and a 2 digit number</span>
						    </div>
		               </div>
		               <div class="form-group">
		                  <label for="psw"> Address</label>
		                  
		                  <textarea name="address" class="form-control" ng-model="MemberEdit.address" ng-maxlength='300' ng-required="true"></textarea>
		                   	<div ng-show="formEdit.$submitted || formEdit.address.$touched">
						        <span class="colorMessages" ng-show="formEdit.address.$error.required">Tell us your address. </span>
						        <span class="colorMessages" ng-show="formEdit.address.$invalid">The address may not be greater than 300 characters.</span>
						    </div>
		               </div>
		               <div class="form-group">
		                  	<label for="psw"> Avatar</label>
		                 	<input type="file" class="form-control" name="photo" file-model="MemberEdit.files" onchange="angular.element(this).scope().uploadImage(files)" />
		                  	<span class="error hieuit"  >@{{messagesErrorimage}}</span>

		                  	<div class="form-group" >
                                <img class="img-thumbnail" style="width:100px;height:80px;" ng-src="{{url('images')}}/@{{image}}" />
                            </div>
		               </div>
		               	<button type="submit" class=" btn btn-default btn-success btn-block" ng-click="save(state,id)" ng-disabled="formEdit.$invalid"><span class="glyphicon glyphicon-off"></span> sửa</button>
		            </form>
		         </div>
		      </div>
		   </div>
		</div> 
	</div> 
</div>	
@endsection

@section ('footer')
	<script src="{{url('js/app/lib/angular.min.js')}}" type="text/javascript"></script>
	<script src="{{url('js/jqueryValidate/jquery.validate.min.js')}}" type="text/javascript"></script>
	<script src="{{url('js/jqueryValidate/additional-methods.min.js')}}" type="text/javascript"></script>
	<script src="{{url('js/app/app.js')}}" type="text/javascript"></script>
	<script src="{{url('js/app/directive.js')}}" type="text/javascript"></script>
	<script src="{{url('js/app/controller/MemberController.js')}}" type="text/javascript"></script>

@endsection