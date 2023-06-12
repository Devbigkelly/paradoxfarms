<div class="row">
         
          <div class="col-md-3">
			<div class="btn-group-vertical support-side-menu">
			<?php if ($this->returns->permission_access('support_tickets_open', $logged_username)){?>
				<a href="<?php echo base_url('admin/support/tickets/open');?>" class="btn btn-default">Open Tickets</a>
			<?php } ?>
			<?php if ($this->returns->permission_access('support_tickets_closed', $logged_username)){?>
				<a href="<?php echo base_url('admin/support/tickets/closed');?>" class="btn btn-default">Closed Tickets</a>
			<?php } ?>
			</div>
		  </div>
          <div class="col-md-9">
            <div class="card card-primary card-outline direct-chat direct-chat-primary">
              
              <div class="card-header">
				<h3 class="card-title">Ticket ID: <?php echo $ticket[0]['ticket_id'];?></h3>
			  </div>
			  <div class="card-body">
					
						
                <div class="direct-chat-messages">
				<?php if (count($data)>0){
				foreach ($data as $m){
				?>
				<?php if ($m['is_reply'] == 1){?>
                  <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-left">Support Team</span>
                      <span class="direct-chat-timestamp float-right"><?php echo $this->general->time_ago($m['updated']);?></span>
                    </div>
                    <img class="direct-chat-img" src="<?php echo base_url($this->general->get_system_var('favicon'));?>" alt="Message User Image">
                    <div class="direct-chat-text">
                      <?php if ($m['is_attachment'] == 1){?>
						<img style="max-width:250px;" src="<?php echo base_url($m['text']);?>">
					  <?php } else {?>
						<span style="white-space: pre;"><?php echo $m['text'];?></span>
					  <?php } ?>
                    </div>
                  </div>
				<?php } else {?>
                  <div class="direct-chat-msg right">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-right"><?php echo $this->user_account->user_name($ticket[0]['username']);?></span>
                      <span class="direct-chat-timestamp float-left"><?php echo $this->general->time_ago($m['updated']);?></span>
                    </div>
                    <img class="direct-chat-img" src="<?php echo $this->user_account->get_small_pic($ticket[0]['username']);?>" alt="Message User Image">
                    <div class="direct-chat-text">
                      <?php if ($m['is_attachment'] == 1){?>
						<img style="max-width:250px;" src="<?php echo base_url($m['text']);?>">
					  <?php } else {?>
						<span style="white-space: pre;"><?php echo $m['text'];?></span>
					  <?php } ?>
                    </div>
                  </div>
				<?php } ?>
				<?php } ?>
				<?php } ?>
                </div>
            </div>
			
			<?php if ($ticket[0]['status'] == 'open'){?>
				<div class="card-footer" style="text-align: right;">
                    <form method="post" action="<?php echo base_url('admin/support/send-message');?>">
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>  
						<?php echo form_hidden('ticket_id', $ticket[0]['id']); ?>
						<div class="input-group">
							<input type="text" name="message" placeholder="Type Message ..." class="form-control">
							<span class="input-group-append">
							  <button type="submit" class="btn btn-primary">Send</button>
							  <button onclick="document.getElementById('attachment').click(); return false" class="btn btn-default"><i class="fas fa-paperclip"></i></button>
							</span>
						</div>
					</form>

					<?php 
					$frm_attributes = array('id' => 'attachment-form', 'name' => 'attachment', 'method' => 'POST');
					echo form_open_multipart('admin/support/attachment', $frm_attributes); ?>
					<input type="file" id="attachment" name="file" accept="image/*" style="display:none; width: 1px; height: 1px" />
					<?php echo form_hidden('ticket_id', $ticket[0]['id']); ?>
					<?php echo form_close();?>
					
					<script>
						document.getElementById("attachment").onchange = function() {
						document.getElementById("attachment-form").submit();
					}
					</script>
				</div>
			<?php } ?>	
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
		
		