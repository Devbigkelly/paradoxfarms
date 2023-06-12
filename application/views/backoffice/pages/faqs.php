<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			</div>
			<div class="card-body">
			<!----------------->
			<?php if (count($data)>0){?>
			<div id="accordion">
				<?php foreach ($data as $key=>$faq){?>
                  <div class="card card-primary">
                    <div class="card-header">
                      <h4 class="card-title w-100">
                        <a class="d-block w-100" data-toggle="collapse" href="#faq_<?php echo $key;?>">
                          <?php echo $faq['question'];?>
                        </a>
                      </h4>
                    </div>
                    <div id="faq_<?php echo $key;?>" class="collapse" data-parent="#accordion">
                      <div class="card-body">
                        <?php echo $faq['answer'];?>
                      </div>
                    </div>
                  </div>
                <?php } ?>  
                  
            </div>
			<?php } ?>
			<!----------------->
			</div>
		</div>
	</div>
</div>
		