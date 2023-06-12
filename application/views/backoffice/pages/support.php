<div class="row">
         
          <div class="col-md-3">
			<div class="btn-group-vertical support-side-menu">
				<a href="<?php echo base_url('member/support');?>" class="btn btn-default active">Generate New Ticket</a>
				<a href="<?php echo base_url('member/support/tickets/open');?>" class="btn btn-default">Open Tickets</a>
				<a href="<?php echo base_url('member/support/tickets/closed');?>" class="btn btn-default">Closed Tickets</a>
			</div>
		  </div>
          <div class="col-md-9">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" action="<?php echo base_url('member/support/generate-ticket');?>">
              <div class="card-header">
				<h3 class="card-title">Generate New Ticket</h3>
			  </div>
			  <div class="card-body">
					
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Title</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="inputName" name="title" placeholder="Title">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Question</label>
                        <div class="col-sm-9">
                          <textarea class="form-control" placeholder="Ask your Question here" name="message" maxlength="255" rows="4"></textarea>
                        </div>
                      </div>
            </div>
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Generate Ticket</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>