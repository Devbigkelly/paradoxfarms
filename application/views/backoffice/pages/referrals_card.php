<div class="row">
	<?php if (count($data)>0){?>
	<?php foreach ($data as $u){
	$card = $this->dashboards->card_details($u['username']);	
	?>
		<div class="col-md-4">
            <div class="card card-widget widget-user">
              <div class="widget-user-header bg-info">
                <a href="<?php echo base_url('member/referrals/tree-view/'.$u['username']);?>"><h3 class="widget-user-username"><?php echo $card['name'];?></h3></a>
                <h5 class="widget-user-desc"><?php echo $u['username'];?></h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle elevation-2" src="<?php echo $card['avatar'];?>" alt="<?php echo $card['name'];?>">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header"><?php echo $card['referrals'];?></h5>
                      <span class="description-text">REFERRALS</span>
                    </div>
                  </div>
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header"><?php echo $card['wallet_amount'];?></h5>
                      <span class="description-text">WALLET AMOUNT</span>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header"><?php echo $card['purchased'];?></h5>
                      <span class="description-text">PRODUCTS</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
	<?php } ?>
	<?php } ?>
	
</div>
		