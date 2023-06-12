
	<div class="row">
	
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $dash['wallet_amount'];?></h3>
                <p>Wallet Amount</p>
              </div>
              <div class="icon">
                <i class="fas fa-wallet"></i>
              </div>
              <a href="<?php echo base_url('admin/wallets');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $dash['total_users'];?></h3>
                <p>Total Users</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-friends"></i>
              </div>
              <a href="<?php echo base_url('admin/users');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $dash['active_users'];?></h3>
                <p>Active Users</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-friends"></i>
              </div>
              <a href="<?php echo base_url('admin/users');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $dash['withdrawn'];?></h3>
                <p>Withdrawn</p>
              </div>
              <div class="icon">
                <i class="fas fa-hand-holding-usd"></i>
              </div>
              <a href="<?php echo base_url('admin/withdraws');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
		
		
		<div class="row">
	
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $dash['open_tickets'];?></h3>
                <p>Open Tickets</p>
              </div>
              <div class="icon">
                <i class="fas fa-angle-left"></i>
              </div>
              <a href="<?php echo base_url('admin/support/tickets/open');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $dash['withdraw_pending'];?></h3>
                <p>Withdraw Pending</p>
              </div>
              <div class="icon">
                <i class="fas fa-hand-holding-usd"></i>
              </div>
              <a href="<?php echo base_url('admin/withdraws');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
		  <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $dash['purchased'];?></h3>
                <p>Products Purchased</p>
              </div>
              <div class="icon">
                <i class="fas fa-list"></i>
              </div>
              <a href="<?php echo base_url('admin/products/purchase-history');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $dash['total_sale'];?></h3>
                <p>Total Sale</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-check-alt"></i>
              </div>
              <a href="<?php echo base_url('admin/products/purchase-history');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        
       <div class="row">
		<div class="col-md-6">
			<div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                  Users' Income
                </h3>

              </div>
              <div class="card-body">
                <div id="bar-chart" style="height: 300px;"></div>
              </div>
              <!-- /.card-body-->
            </div>
            <!-- /.card -->
			</div>
			<div class="col-md-6">
			<div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Users' Income</h3>

              </div>
              <div class="card-body">
                <div class="chart">
                  <div id="bonus-chart" style="height: 300px;"></div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
			</div>
		</div>
		
<script>
$(function () {
	var bonus_data = {
       data : <?php echo $bonus_chart;?>,
      bars: { show: true }
    }
    $.plot('#bonus-chart', [bonus_data], {
      grid  : {
        borderWidth: 1,
        borderColor: '#f3f3f3',
        tickColor  : '#f3f3f3'
      },
      series: {
         bars: {
          show: true, barWidth: 0.5, align: 'center',
        },
      },
      colors: ['#3c8dbc'],
      xaxis : {
        ticks: [[1,'P-S-B'], [2,'N-B-B'], [3,'G-B'], [4,'R-G-B'], [5,'ROI'], [6,'Matching ROI']]
      }
    })
	
	var bar_data = {
      data : <?php echo $bar_chart_income;?>,
      bars: { show: true }
    }
    $.plot('#bar-chart', [bar_data], {
      grid  : {
        borderWidth: 1,
        borderColor: '#f3f3f3',
        tickColor  : '#f3f3f3'
      },
      series: {
         bars: {
          show: true, barWidth: 0.5, align: 'center',
        },
      },
      colors: ['#3c8dbc'],
      xaxis : {
        ticks: <?php echo $bar_chart_months;?>
      }
    })
    /* END BAR CHART */
})
</script>