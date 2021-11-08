<div class="modal fade" id="TrainerAdd" tabindex="-1" role="dialog" aria-labelledby="BlogsAddModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="BlogsAddModal">Add Certificate</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('certificate-store') }}" method="POST" enctype="multipart/form-data">
            @csrf
              <div class="form-group">
                <label for="classroom_course_title" >Name</label>
                <input data-validation="required" type="text" class="form-control" name="user_name" aria-describedby="name" placeholder="Enter Name">
              </div>

              <div class="form-group">
                <label for="custom select">Select Language</label>
                <select class="form-control" name="language">
                  <option label="Choose Course"></option>
                    <option value="bangla">বাংলা</option>
                    <option value="english">English</option>

                </select>
              </div>
              <div class="form-group">
                <label class="col-form-label">Date</label>
                <div>
                  <input  type="date" class="form-control" name="date"> </input>
                </div>
              </div>
              <div class="form-group">
                <label class="col-form-label">Course Name</label>
                <div>
                  <input  class="form-control" name="course_name"> </input>
                </div>
              </div>
              <div class="form-group">
                <label class="col-form-label">Trainer Name</label>
                <div>
                  <input  class="form-control" name="trainer_name"> </input>
                </div>
              </div>
                   <div class="form-group">
                    <label class="form-control-label">Signature: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="file" name="signature"  onchange="Signatures(this)" data-validation="required">
                  <img src="" id="mainThmb">
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
          </form>
      </div>
    </div>
  </div>
    <script src="{{asset('backend')}}/lib/jquerysubsubcategory/jquery-2.2.4.min.js"></script>
    <script>
        function Signatures(input){
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e){
                $('#mainThmb').attr('src',e.target.result).width(80)
                      .height(80);
            };
            reader.readAsDataURL(input.files[0]);
          }
        }
      </script>
