<div class="card card-primary rounded-0">
    <div class="card-header">
        <h4 class="text-muted"><i class="far fa-plus-square"></i> Add Candidate Information</h4>
    </div>
    <div class="card-body">
        <div class="contianer-fluid">
            <form action="<?= base_url('candidate_curd/save') ?>" method="POST" id="create-form" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= isset($data['id']) ? $data['id'] : '' ?>">   
                <?= csrf_field() ?>             
                <div class="mb-3">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="" class="control-label">Name</label>
                            <input type="text" autofocus class="form-control form-control-border" id="name" name="name" value="<?= isset($data['name']) ? $data['name'] : '' ?>" required="required" placeholder="Name">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="gender" class="control-label">Gender</label>
                            <select name="gender" id="gender" class="form-select form-select-border" required>
                                <option <?= isset($data['gender']) && $data['gender'] == 'Male' ? 'selecte' : '' ?>>Male</option>
                                <option <?= isset($data['gender']) && $data['gender'] == 'Female' ? 'selecte' : '' ?>>Female</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="contact" class="control-label">Contact</label>
                            <input type="text" class="form-control" id="contact" name="contact" required="required" value="<?= isset($data['contact']) ? $data['contact'] : '' ?>">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="email" class="control-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required="required" value="<?= isset($data['email']) ? $data['email'] : '' ?>">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="education_qualification" class="control-label">Education Qualification</label>
                            <input type="text" class="form-control" id="education_qualification" name="education_qualification" required="required" value="<?= isset($data['education_qualification']) ? $data['education_qualification'] : '' ?>">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="resume" class="control-label">Resume</label>
                            <input type="file" class="form-control" accept="application/pdf" id="resume" name="resume" value="">
                            <?php  if(isset($data['resume'])): ?>
                                <a href="<?="/uploads/resume/".$data['resume']?>" target="_blank">View RESUME</a>
                            <?php endif ?>
                            
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="profile_img" class="control-label">Photo</label>
                            <input type="file" class="form-control" accept="image/png, image/gif, image/jpeg" id="profile_img" name="profile_img" value="">
                            <?php  if(isset($data['profile_img'])): ?>
                            <img src="<?="/uploads/photo/".$data['profile_img']?>" width="100px" height="100px">
                            <?php endif ?>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card-footer text-center">
        <button class="btn btn-primary" form="create-form" type="submit"><i class="fa fa-save"></i> Save</button>
    </div>
</div>