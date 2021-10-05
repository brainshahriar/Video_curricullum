@extends('admin.admin_master')
@section('admin_dashboard_content')

<div class="container-fluid">
  <div class="db-breadcrumb">
    <h4 class="breadcrumb-title">Users</h4>
    <ul class="db-breadcrumb-list">
      <li><a href="{{route('admin.home')}}"><i class="fa fa-home"></i>Home</a></li>
      <li>User</li>
    </ul>
  </div>
  @if(Session::has('user_deleted'))
  <div class="alert alert-danger" role="alert">

    <div class="alert-body">
      {{Session::get('user_deleted')}}
    </div>
  </div>
  @endif
  <!-- Card -->

  <div class="row" id="basic-table">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Users</h4>
       <a href="#" class="btn btn-success" data-toggle="modal" data-target="#"><i class="fas fa-plus"></i></a>
        </div>


        <!-- Modal -->

        <div class="table table-responsive">
          <table id="user_list" class="table table-bordered">
            <thead>
              <tr>
                <th>Id</th>
                <th>User Name</th>

                <th>Email</th>
                <th>Phone Number</th>
                <th>Role</th>
                <th>Enrollment</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $users = App\Models\User::all();

               ?>
              @foreach ($users as $row)

              <tr>
                <td>{{$row->id}}</td>
                <td>
                    {{$row->name}}

                </td>

                <td>
                    {{$row->email}}
                </td>
                <td>
                    0{{$row->phone}}
                </td>
                <td>
                  @if($row->is_admin==1)
                  Admin
                  @else
                  User
                  @endif


                </td>

                <td><span class="badge badge-pill badge-light-primary mr-1"></span></td>
                <td>
                  <a href="#"><i class="fas fa-edit"></i></a>
                  <a id="delete" href="/admin/home/users/delete/{{$row->id}}"><i class="fas fa-trash"></i></a>
                  <a data-toggle="modal" data-target="#EnrollCourseModal{{$row->id}}"><i class="fab fa-accessible-icon"></i></a>
                    @include('backend.modals.enroll')
                </td>

              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>
<style>
    .btn:active, .btn:hover, .btn:focus, .active > .btn {
        background-color: #d8a409;
         color: #000000;
    }
</style>
<script>
  $(function(){
    'use strict';

    $('#user_list').DataTable({
      responsive: true,
      language: {
        searchPlaceholder: 'Search...',
        sSearch: '',
        lengthMenu: '_MENU_ ',
      }
    });
  })
  function coursePrice(){
      var course_id = $('#course_id').val();
      if ((course_id == null || course_id == 0)) return;

      $.ajax({
          type: "GET",
          url: '{{route('get.product-price')}}',
          //dataType: 'json',
          data: {
              "_token": "{{ csrf_token() }}",'course_id':course_id
          },

          success: function (response) {
              var obj = jQuery.parseJSON(response);
              console.log(obj)
              $('#regular_price').val(obj.regular_price);

          },
          error: function () {
          }
      });
  }
  $('#course_enroll').on('submit', function(event){
      event.preventDefault();
      //var course_id = $('#asset_id').val();
      //var po_no = $('#po_no').val();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
          type    : "post",
          url: '{{ route("enroll-course.store") }}',
          data: $('#course_enroll').serialize(),
          success : function (response) {

              $('#categoryChangeEdit').modal('hide');

              $("#myToast").showToast({
                  message: 'Updated successfully!',
                  duration: 2500,
                  mode: 'success'
              });

              $('#assetization-list-new-table').dataTable().fnDestroy();
              $('#assetization-list-assetized-table').dataTable().fnDestroy();
              $('#wip-new-table').dataTable().fnDestroy();

              AssetizationListNew(asset_id, po_no);
              AssetizationListAssetized(asset_id, po_no);
              newWip(asset_id, po_no);


          },
          error : function (error_response) {

              $('form').find('.help-block').remove();
              $('form').find('.form-group').removeClass('has-error');

              $.each(error_response.responseJSON, function(key,value) {

                  $('#error_span').append('<li>'+value+'</li>').addClass('alert alert-danger');
                  $('#' + key ).parent().parent().append('<div class="col-sm-7 help-block">' + value + '</div>').closest('.form-group').removeClass('has-error').addClass('has-error');

              });

          }
      });
  });
</script>

<script>
        function previewImage(input){
          var file=$("input[type=file]").get(0).files[0];
          if(file)
          {
            var reader = new FileReader();
            reader.onload =function()
            {
              $('#image').attr("src",reader.result);
            }
            reader.readAsDataURL(file);
          }
        }

</script>



@endsection
