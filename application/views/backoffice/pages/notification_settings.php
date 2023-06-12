<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			</div>
			<div class="card-body">
			<form method="post" action="<?php echo base_url('member/profile/notification-settings/do');?>" enctype="multipart/form-data">
				<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
				<input type="hidden" name="username" value="<?php echo $this->session->userdata('user_name');?>">
				<table class="table">
					<thead>
						<tr>
							<td>Notification</td>
							<td>SMS</td>
							<td>Email</td>
						</tr>
					</thead>
					<tbody>
						<?php if (count($templates)>0){?>
						<?php foreach($templates as $key=>$notification){
							$type = $notification['type'];
							$username = $this->session->userdata('user_name');
							$user_sms = $this->db->query("SELECT * FROM notification_settings WHERE type = '$type' AND username = '$username' AND carrier_type = 'sms'")->result_array();
							$user_email = $this->db->query("SELECT * FROM notification_settings WHERE type = '$type' AND username = '$username' AND carrier_type = 'email'")->result_array();
							//echo '<pre>';
							//print_r($user_set);
						?>
						<tr>
							<td><?php echo $notification['title'];?></td>
							<td><input type="checkbox" name="notification[<?php echo $notification['type'];?>][sms]" value="1" <?php if (count($user_sms)>0){echo 'checked';}?><?php if ($notification['sms'] == '0'){echo 'disabled';}?> ></td>
							<td><input type="checkbox" name="notification[<?php echo $notification['type'];?>][email]" value="1" <?php if (count($user_email)>0){echo 'checked';} ?> <?php if ($notification['email'] == '0'){echo 'disabled';}?>></td>
						</tr>
						<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="card-footer" style="text-align: right;">
                <button type="submit" class="btn btn-primary">Update Notification Settings</button>
			</div>
			</form>
		</div>
	</div>
</div>
