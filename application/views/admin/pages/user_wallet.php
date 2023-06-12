<div class="row">
	<div class="col-md-6">
		<div class="card card-primary card-outline">
			<form class="form-horizontal" method="post" action="<?php echo base_url('admin/wallets/add-funds');?>">
				<div class="card-header">
					<h3 class="card-title">Add Funds to Wallet</h3>
				</div>
				<div class="card-body">
					<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
					<?php echo form_hidden('username', $username); ?>
					<div class="form-group row">
						<label for="inputEmail" class="col-sm-3 col-form-label">Amount</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="inputEmail" name="amount" placeholder="Amount">
						</div>
					</div>
				</div>
				<div class="card-footer" style="text-align: right;">
					<button type="submit" class="btn btn-primary">Add Funds</button>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card card-primary card-outline">
			<form class="form-horizontal" method="post" action="<?php echo base_url('admin/wallets/deduct-funds');?>">
				<div class="card-header">
					<h3 class="card-title">Deduct Funds From Wallet</h3>
				</div>
				<div class="card-body">
					<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
					<?php echo form_hidden('username', $username); ?>
					<div class="form-group row">
						<label for="inputEmail" class="col-sm-3 col-form-label">Amount</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="inputEmail" name="amount" placeholder="Amount">
						</div>
					</div>
				</div>
				<div class="card-footer" style="text-align: right;">
					<button type="submit" class="btn btn-primary">Deduct Funds</button>
				</div>
			</form>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="card card-primary card-outline">
			<form class="form-horizontal" method="post" action="<?php echo base_url('admin/wallets/bonus-status');?>">
				<div class="card-header">
					<h3 class="card-title">Disable Bonus</h3>
				</div>
				<div class="card-body">
					<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
					<?php echo form_hidden('username', $username); ?>
					<div class="form-group row">
						<label for="inputEmail" class="col-sm-3 col-form-label">Disable Bonus</label>
						<div class="col-sm-9">
							<div class="form-group clearfix">
							  <div class="icheck-primary d-inline">
								<input type="checkbox" id="psb_disabled" name="psb_disabled" <?php if ($this->commissions->is_commission_disabled($username, 'personal-sponsor-bonus')){echo 'checked';}?>>
								<label for="psb_disabled">Personal Sponsor Bonus</label>
							  </div>
							</div>
							<div class="form-group clearfix">
							  <div class="icheck-primary d-inline">
								<input type="checkbox" id="nbb_disabled" name="nbb_disabled" <?php if ($this->commissions->is_commission_disabled($username, 'network-binary-bonus')){echo 'checked';}?>>
								<label for="nbb_disabled">Network Binary Bonus</label>
							  </div>
							</div>
							<div class="form-group clearfix">
							  <div class="icheck-primary d-inline">
								<input type="checkbox" id="gb_disabled" name="gb_disabled" <?php if ($this->commissions->is_commission_disabled($username, 'generation-bonus')){echo 'checked';}?>>
								<label for="gb_disabled">Generation Bonus</label>
							  </div>
							</div>
							<div class="form-group clearfix">
							  <div class="icheck-primary d-inline">
								<input type="checkbox" id="rgb_disabled" name="rgb_disabled" <?php if ($this->commissions->is_commission_disabled($username, 'reverse-generation-bonus')){echo 'checked';}?>>
								<label for="rgb_disabled">Reverse Generation Bonus</label>
							  </div>
							</div>
							<div class="form-group clearfix">
							  <div class="icheck-primary d-inline">
								<input type="checkbox" id="roi_disabled" name="roi_disabled" <?php if ($this->commissions->is_commission_disabled($username, 'roi')){echo 'checked';}?>>
								<label for="roi_disabled">Return on Investment</label>
							  </div>
							</div>
							<div class="form-group clearfix">
							  <div class="icheck-primary d-inline">
								<input type="checkbox" id="mroi_disabled" name="mroi_disabled" <?php if ($this->commissions->is_commission_disabled($username, 'matching-roi')){echo 'checked';}?>>
								<label for="mroi_disabled">Matching ROI</label>
							  </div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer" style="text-align: right;">
					<button type="submit" class="btn btn-primary">Update Bonus Status</button>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card card-primary card-outline">
			<form class="form-horizontal" method="post" action="<?php echo base_url('admin/wallets/wallet-status');?>">
				<div class="card-header">
					<h3 class="card-title">Disable Wallet</h3>
				</div>
				<div class="card-body">
					<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
					<?php echo form_hidden('username', $username); ?>
					<div class="form-group row">
						<label for="inputEmail" class="col-sm-3 col-form-label">Disable Wallet</label>
						<div class="col-sm-9">
							<div class="form-group clearfix">
							  <div class="icheck-primary d-inline">
								<input type="checkbox" id="withdraw_disabled" name="withdraw_disabled" <?php if ($this->returns->withdraw_disabled($username)){echo 'checked';}?>>
								<label for="withdraw_disabled">Disable Withdraw</label>
							  </div>
							</div>
							<div class="form-group clearfix">
							  <div class="icheck-primary d-inline">
								<input type="checkbox" id="transfer_disabled" name="transfer_disabled" <?php if ($this->returns->transfer_disabled($username)){echo 'checked';}?>>
								<label for="transfer_disabled">Disable Transfer</label>
							  </div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer" style="text-align: right;">
					<button type="submit" class="btn btn-primary">Update Wallet Status</button>
				</div>
			</form>
		</div>
	</div>
</div>