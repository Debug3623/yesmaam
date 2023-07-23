<?= $this->extend('layouts/front_template.php') ?>

<?= $this->section('breadcrumbs'); ?>
<!-- BEGIN PAGE TITLE/BREADCRUMB -->
<div class="parallax colored-bg pattern-bg" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-title">Nurse Profile</h1>
                
                <ul class="breadcrumb">
                    <li><a href="<?= site_url('/') ?>">Home </a></li>
                    <li>Nurse Profile</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE TITLE/BREADCRUMB -->
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<!-- BEGIN CONTENT WRAPPER -->
<div class="content">
    <div class="container">
        <div class="row">
            <!-- BEGIN SIDEBAR 
            <div class="sidebar col-sm-3">
                <ul class="list-group">
                    <li class="list-group-item active"><a href="<?= site_url('nurse/profile') ?>">Profile</a></li>
                    <li class="list-group-item"><a href="<?= site_url('nurse/bookings') ?>">Bookings</a></li>
                    <li class="list-group-item"><a href="<?= site_url('nurse/logout') ?>" style="color: red;">Logout</a></li>
                </ul>
            </div>-->
            <!-- END SIDEBAR -->
            <div class="col-md-3">
                <?php if($nurse->photo): ?>
              	<img src="<?= site_url($nurse->photo) ?>" class="img img-responsive" style="width: 50%;" />
              	<?php else: ?>
              	<img src="<?= site_url('images/nurses/nurse placeholder.jpg') ?>" class="img img-responsive" style="width: 50%;" />
              	<?php endif; ?>
                <p>
                    <a href="<?= site_url('nurse/profile') ?>" class="btn btn-primary" style="width: 50%; margin-top: 5px;">Profile</a><br />
                    <a href="<?= site_url('nurse/bookings') ?>" class="btn btn-warning" style="width: 50%; margin-top: 5px;">Bookings</a><br />
                    <a href="<?= site_url('nurse/logout') ?>" class="btn btn-danger" style="width: 50%; margin-top: 5px;">Logout</a>
                </p>
            </div>


            <!-- BEGIN MAIN CONTENT -->
            <div class="main col-sm-8">
                <h3 style="margin-bottom: 30px;">Your Details<?php if($nurse->status == 0){ ?> - <small> Complete your profile to activate your account</small> <?php } ?></h3>
                <div class="card card-primary">
                  <div class="card-header"></div>
                  <div class="card-body">
					<form method="post" action="<?= site_url('nurse/profile-update') ?>" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" class="form-control" id="first_name" value="<?= $nurse->first_name ?>" />

                                <?php if(isset($validator) && $validator->hasError('first_name')): ?>
                                <div class="text-danger"><?= $validator->getError('first_name'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="middle_name">Middle Name</label>
                                <input type="text" name="middle_name" class="form-control" id="middle_name" value="<?= $nurse->middle_name ?>" />

                                <?php if(isset($validator) && $validator->hasError('middle_name')): ?>
                                <div class="text-danger"><?= $validator->getError('middle_name'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" class="form-control" id="last_name" value="<?= $nurse->last_name ?>" />

                                <?php if(isset($validator) && $validator->hasError('last_name')): ?>
                                <div class="text-danger"><?= $validator->getError('last_name'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" class="form-control" id="email" value="<?= $nurse->email ?>" />

                                <?php if(isset($validator) && $validator->hasError('email')): ?>
                                <div class="text-danger"><?= $validator->getError('email'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" class="form-control" id="phone" value="<?= $nurse->phone ?>" />

                                <?php if(isset($validator) && $validator->hasError('phone')): ?>
                                <div class="text-danger"><?= $validator->getError('phone'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="work_title">Work Title</label>
                                <input type="text" name="work_title" class="form-control" id="work_title" value="<?php if($nurse->work_title != ''){ echo $nurse->work_title; } else { echo set_value('work_title'); } ?>" />

                                <?php if(isset($validator) && $validator->hasError('work_title')): ?>
                                <div class="text-danger"><?= $validator->getError('work_title'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="expertise">Expertise</label>
                                <input type="text" name="expertise" class="form-control" id="expertise" value="<?php if($nurse->expertise != ''){ echo $nurse->expertise; } else { echo set_value('expertise'); } ?>" />

                                <?php if(isset($validator) && $validator->hasError('expertise')): ?>
                                <div class="text-danger"><?= $validator->getError('expertise'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="about">About</label>
                                <textarea name="about" class="form-control" id="about"><?php if($nurse->about != ''){ echo $nurse->about; } else { echo set_value('about'); } ?></textarea>

                                <?php if(isset($validator) && $validator->hasError('about')): ?>
                                <div class="text-danger"><?= $validator->getError('about'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" class="form-control" id="category">
                                    <?php foreach($categories as $cate): ?>
                                    <option value="<?= $cate->id ;?>" <?php if($nurse->category == $cate->id || set_value('category') == $cate->id){ echo 'selected'; } ?>><?= $cate->name; ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <?php if(isset($validator) && $validator->hasError('category')): ?>
                                <div class="text-danger"><?= $validator->getError('category'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="working_hours">Working Hours</label>
                                <input type="text" name="working_hours" class="form-control" id="working_hours" value="<?php if($nurse->working_hours != ''){ echo $nurse->working_hours; } else { echo set_value('working_hours'); } ?>" placeholder="Ex. 10:00 AM to 08:00 PM" />

                                <?php if(isset($validator) && $validator->hasError('working_hours')): ?>
                                <div class="text-danger"><?= $validator->getError('working_hours'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_of_birth">Date of Birth</label>
                                <input type="text" name="date_of_birth" class="form-control" id="date_of_birth" value="<?php if($nurse->date_of_birth != ''){ echo $nurse->date_of_birth; } else { echo set_value('date_of_birth'); } ?>" />

                                <?php if(isset($validator) && $validator->hasError('date_of_birth')): ?>
                                <div class="text-danger"><?= $validator->getError('date_of_birth'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="marital_status">Marital Status</label>
                                <select name="marital_status" class="form-control" id="marital_status">
                                    <?php foreach($statuses as $s): ?>
                                        <option value='<?= $s; ?>' <?php if($nurse->marital_status == $s || set_value('marital_status') == $s){ echo 'selected'; } ?>><?= ucfirst($s) ?></option>
                                    <?php endforeach; ?>                        
                                </select>

                                <?php if(isset($validator) && $validator->hasError('marital_status')): ?>
                                <div class="text-danger"><?= $validator->getError('marital_status'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="skills">skills</label>
                                <input type="text" name="skills" class="form-control" id="skills" value="<?php if($nurse->skills != ''){ echo $nurse->skills; } else { echo set_value('skills'); } ?>" />

                                <?php if(isset($validator) && $validator->hasError('skills')): ?>
                                <div class="text-danger"><?= $validator->getError('skills'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="visa_type">Visa Type</label>
                                <select name="visa_type" class="form-control" id="visa_type">
                                    <?php foreach($visas as $s): ?>
                                        <option value='<?= $s; ?>' <?php if($nurse->visa_type == $s || set_value('visa_type') == $s){ echo 'selected'; } ?>><?= ucfirst($s) ?></option>
                                    <?php endforeach; ?>   
                                </select>

                                <?php if(isset($validator) && $validator->hasError('visa_type')): ?>
                                <div class="text-danger"><?= $validator->getError('visa_type'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" name="city" class="form-control" id="city" value="<?php if($nurse->city != ''){ echo $nurse->city; } else { echo set_value('city'); } ?>" />

                                <?php if(isset($validator) && $validator->hasError('city')): ?>
                                <div class="text-danger"><?= $validator->getError('city'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" name="address" class="form-control" id="address" value="<?php if($nurse->address != ''){ echo $nurse->address; } else { echo set_value('address'); } ?>" />

                                <?php if(isset($validator) && $validator->hasError('address')): ?>
                                <div class="text-danger"><?= $validator->getError('address'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="photo">Photo</label>
                                <input type="file" name="photo" class="form-control" id="photo" />

                                <?php if(isset($validator) && $validator->hasError('photo')): ?>
                                <div class="text-danger"><?= $validator->getError('photo'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <?php if($nurse->photo != ''): ?>
                                <img src="<?= site_url($nurse->photo) ?>" height="150px">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="working_type">Working Type</label>
                                <select name="working_type" class="form-control" id="working_type">
                                    <?php foreach($work_types as $s): ?>
                                        <option value='<?= $s; ?>' <?php if($nurse->working_type == $s || set_value('working_type') == $s){ echo 'selected'; } ?>><?= ucfirst($s) ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <?php if(isset($validator) && $validator->hasError('working_type')): ?>
                                <div class="text-danger"><?= $validator->getError('working_type'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="eid">Emirates ID (EID)*</label>
                                <input type="text" name="eid" class="form-control" id="eid" value="<?= set_value('eid') ?>" />

                                <?php if(isset($validator) && $validator->hasError('eid')): ?>
                                <div class="text-danger"><?= $validator->getError('eid'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="passport_no">Passport No</label>
                                <input type="text" name="passport_no" class="form-control" id="passport_no" value="<?= set_value('passport_no') ?>" />

                                <?php if(isset($validator) && $validator->hasError('passport_no')): ?>
                                <div class="text-danger"><?= $validator->getError('passport_no'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="passport">Passport Photo Copy</label>
                                <input type="file" name="passport" class="form-control" id="passport" />

                                <?php if(isset($validator) && $validator->hasError('passport')): ?>
                                <div class="text-danger"><?= $validator->getError('passport'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nationality">Nationality</label>
                                <input type="text" name="nationality" class="form-control" id="nationality" value="<?php if($nurse->nationality != ''){ echo $nurse->nationality; } else { echo set_value('nationality'); } ?>" />

                                <?php if(isset($validator) && $validator->hasError('nationality')): ?>
                                <div class="text-danger"><?= $validator->getError('nationality'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="experience">Experience</label>
                                <input type="text" name="experience" class="form-control" id="experience" value="<?php if($nurse->experience != ''){ echo $nurse->experience; } else { echo set_value('experience'); } ?>" />

                                <?php if(isset($validator) && $validator->hasError('experience')): ?>
                                <div class="text-danger"><?= $validator->getError('experience'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="submit" value="Submit" class="btn btn-success" />
                    </div>

                </form>
                  </div>
                </div>
                
                

            </div>  
            <!-- END MAIN CONTENT -->
        </div>
    </div>
</div>
<!-- END CONTENT WRAPPER -->
<?= $this->endSection(); ?>