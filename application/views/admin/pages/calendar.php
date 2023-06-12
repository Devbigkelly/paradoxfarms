<link href='<?php echo base_url('assets/backend/plugins/calander/');?>core/main.css' rel='stylesheet' />
<link href='<?php echo base_url('assets/backend/plugins/calander/');?>daygrid/main.css' rel='stylesheet' />
<link href='<?php echo base_url('assets/backend/plugins/calander/');?>timegrid/main.css' rel='stylesheet' />
<link href='<?php echo base_url('assets/backend/plugins/calander/');?>list/main.css' rel='stylesheet' />
<link href="<?php echo base_url('assets/backend/plugins/calander/');?>jqueryui/custom-theme/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">
<link href='<?php echo base_url('assets/backend/plugins/calander/');?>bootstrap-datetimepicker.css' rel='stylesheet' />
<link href='<?php echo base_url('assets/backend/plugins/calander/');?>colorpicker/bootstrap-colorpicker.min.css' rel='stylesheet' />



<script src='<?php echo base_url('assets/backend/plugins/calander/');?>core/main.js'></script>
<script src='<?php echo base_url('assets/backend/plugins/calander/');?>daygrid/main.js'></script>
<script src='<?php echo base_url('assets/backend/plugins/calander/');?>timegrid/main.js'></script>
<script src='<?php echo base_url('assets/backend/plugins/calander/');?>list/main.js'></script>
<script src='<?php echo base_url('assets/backend/plugins/calander/');?>interaction/main.js'></script>
<script src='<?php echo base_url('assets/backend/plugins/calander/');?>jqueryui/jqueryui.min.js'></script>
<script src="<?php echo base_url('assets/backend/');?>plugins/moment/moment.min.js"></script>
<script src='<?php echo base_url('assets/backend/plugins/calander/');?>bootstrap/js/bootstrap.js'></script>
<script src='<?php echo base_url('assets/backend/plugins/calander/');?>bootstrap-datetimepicker.min.js'></script>
<script src='<?php echo base_url('assets/backend/plugins/calander/');?>colorpicker/bootstrap-colorpicker.min.js'></script>
<script src='<?php echo base_url('assets/backend/plugins/calander/');?>calendar.js'></script>
<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
				<?php if ($this->returns->permission_access('calender_add', $logged_username)){?>
				<div class="card-tools">
					<button type="button" href="#" class="btn btn-tool" data-toggle="modal" data-target="#addeventmodal">
						<i class="fas fa-plus"></i> Create New Event
					</button>
				</div>
				<?php } ?>
			</div>
			<div class="card-body">
				<div id="calendar"></div>
			</div>
		</div>
	</div>
</div>

<!----------------------------------------------------------->
<?php if ($this->returns->permission_access('calender_add', $logged_username)){?>
<div class="modal fade" id="addeventmodal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="container-fluid">

                    <form id="createEvent" class="form-horizontal">

                    <div class="row">

                        <div class="col-md-6">

                            <div id="title-group" class="form-group">
                                <label class="control-label" for="title">Title</label>
                                <input type="text" class="form-control" name="title">
                                <!-- errors will go here -->
                            </div>

                            <div id="startdate-group" class="form-group">
                                <label class="control-label" for="startDate">Start Date</label>
                                <input type="text" class="form-control datetimepicker" id="startDate" name="startDate">
                                <!-- errors will go here -->
                            </div>

                            <div id="enddate-group" class="form-group">
                                <label class="control-label" for="endDate">End Date</label>
                                <input type="text" class="form-control datetimepicker" id="endDate" name="endDate">
                                <!-- errors will go here -->
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div id="color-group" class="form-group">
                                <label class="control-label" for="color">Colour</label>
                                <input type="text" class="form-control colorpicker" name="color" value="#6453e9">
                                <!-- errors will go here -->
                            </div>

                            <div id="textcolor-group" class="form-group">
                                <label class="control-label" for="textcolor">Text Colour</label>
                                <input type="text" class="form-control colorpicker" name="text_color" value="#ffffff">
                                <!-- errors will go here -->
                            </div>

                        </div>
						<div class="col-md-12">
							<label class="control-label" for="details">Event Details</label>
							<textarea class="form-control" id="details" name="details"></textarea>
						</div>

                    </div>

                    

                </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>

            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php } ?>
<?php if ($this->returns->permission_access('calender_edit', $logged_username)){?>
<div class="modal fade" id="editeventmodal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Update Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="container-fluid">

                    <form id="editEvent" class="form-horizontal">
                    <input type="hidden" id="editEventId" name="editEventId" value="">

                    <div class="row">

                        <div class="col-md-6">

                            <div id="edit-title-group" class="form-group">
                                <label class="control-label" for="editEventTitle">Title</label>
                                <input type="text" class="form-control" id="editEventTitle" name="editEventTitle">
                                <!-- errors will go here -->
                            </div>

                            <div id="edit-startdate-group" class="form-group">
                                <label class="control-label" for="editStartDate">Start Date</label>
                                <input type="text" class="form-control datetimepicker" id="editStartDate" name="editStartDate">
                                <!-- errors will go here -->
                            </div>

                            <div id="edit-enddate-group" class="form-group">
                                <label class="control-label" for="editEndDate">End Date</label>
                                <input type="text" class="form-control datetimepicker" id="editEndDate" name="editEndDate">
                                <!-- errors will go here -->
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div id="edit-color-group" class="form-group">
                                <label class="control-label" for="editColor">Colour</label>
                                <input type="text" class="form-control colorpicker" id="editColor" name="editColor" value="#6453e9">
                                <!-- errors will go here -->
                            </div>

                            <div id="edit-textcolor-group" class="form-group">
                                <label class="control-label" for="editTextColor">Text Colour</label>
                                <input type="text" class="form-control colorpicker" id="editTextColor" name="editTextColor" value="#ffffff">
                                <!-- errors will go here -->
                            </div>

                        </div>
						<div class="col-md-12">
							<label class="control-label" for="editdetails">Event Details</label>
							<textarea class="form-control" id="editdetails" name="editdetails"></textarea>
						</div>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
              <button type="button" class="btn btn-danger" id="deleteEvent" data-id>Delete</button>
            </div>

            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php } ?>
<script type="text/javascript">
      $('.datetimepicker').datetimepicker({
			format: 'DD/MM/YYYY hh:mm:ss',
      });
    </script>		