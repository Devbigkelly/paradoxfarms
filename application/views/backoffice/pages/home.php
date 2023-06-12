<div class="row">
	<div class="col-md-12">
		<div class="card card-success">
		  <div class="card-body referral-link" style="padding: 5px 5px 5px 10px;">
			<div class="row">
				<div class="col-md-9" style="line-height: 38px;">
					<span>Referral Link: </span>
					<a class="ref_link" href="<?php echo base_url('auth/register/'.$this->session->userdata('user_name'));?>"><?php echo base_url('auth/register/'.$this->session->userdata('user_name'));?></a>
				</div>
				<div class="col-md-3">
					<?php if ($this->general->get_system_var('invitation_status') == '1'){?>
					<a href="<?php echo base_url('member/invitation');?>" class="btn btn-primary btn-block">Invite New Referral</a>
					<?php } ?>
				</div>
			</div>
		   </div>
		</div>
	</div>
</div>


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
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
              <a href="<?php echo base_url('member/referrals/list-view');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
              <a href="<?php echo base_url('member/referrals/list-view');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
              <a href="<?php echo base_url('member/withdraw/history');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
		
		<!----<div class="row">
	
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $dash['psb'];?></h3>
                <p>Personal Sponsor Bonus</p>
              </div>
              <div class="icon">
                <i class="fas fa-gift"></i>
              </div>
              <a href="<?php echo base_url('member/income/personal-sponsor-bonus');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $dash['nbb'];?></h3>
                <p>Network Binary Bonus</p>
              </div>
              <div class="icon">
                <i class="fas fa-gift"></i>
              </div>
              <a href="<?php echo base_url('member/income/network-binary-bonus');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $dash['gb'];?></h3>
                <p>Generation Bonus</p>
              </div>
              <div class="icon">
                <i class="fas fa-gift"></i>
              </div>
              <a href="<?php echo base_url('member/income/generation-bonus');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $dash['rgb'];?></h3>
                <p>Reverse Generation Bonus</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-check-alt"></i>
              </div>
              <a href="<?php echo base_url('member/income/reverse-generation-bonus');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>---->
		
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
              <a href="<?php echo base_url('member/support/tickets/open');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
              <a href="<?php echo base_url('member/withdraw/history');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
		  </div>
          <!---<div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $dash['roi'];?></h3>
                <p>ROI</p>
              </div>
              <div class="icon">
                <i class="fas fa-list"></i>
              </div>
              <a href="<?php echo base_url('member/income/roi');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $dash['matching_roi'];?></h3>
                <p>Matching ROI</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-check-alt"></i>
              </div>
              <a href="<?php echo base_url('member/income/matching-roi');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>--->
          
		  <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $dash['purchased'];?></h3>
                <p>Products Purchased</p>
              </div>
              <div class="icon">
                <i class="fas fa-list"></i>
              </div>
              <a href="<?php echo base_url('member/products/purchase-history');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <!---<div class="row">
          
          
         <div class="col-md-6">
			<div class="row">
			
		  
		  <div class="col-lg-6 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $dash['open_tickets'];?></h3>
                <p>Open Tickets</p>
              </div>
              <div class="icon">
                <i class="fas fa-angle-left"></i>
              </div>
              <a href="<?php echo base_url('member/support/tickets/open');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
		  <div class="col-lg-6 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $dash['withdraw_pending'];?></h3>
                <p>Withdraw Pending</p>
              </div>
              <div class="icon">
                <i class="fas fa-hand-holding-usd"></i>
              </div>
              <a href="<?php echo base_url('member/withdraw/history');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          </div>
         </div>
         
        </div>--->
       
<div class="row">
          <div class="col-md-12">
            <!-- Line chart -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                  Sale / Income
                </h3>

              </div>
              <div class="card-body">
                <div id="line-chart" style="height: 300px;"></div>
              </div>
              <!-- /.card-body-->
            </div>
            <!-- /.card -->
			</div>
			
			<div class="col-md-12">
			<div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Earned Bonus</h3>

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
//-------------
    //- BAR CHART -
    //-------------
	
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
        ticks: [[1,'Personal Sponsor Bonus'], [2,'Network Bonus'], [3,'Generation Bonus'], [4,'Reverse Generation'], [5,'ROI'], [6,'Matching ROI']]
      }
    })

    /*
     * LINE CHART
     * ----------
     */
    
	//console.log(<?php echo $line_chart_direct;?>);
	
    var line_data1 = {
      data : <?php echo $line_chart_direct;?>,
      color: '#3c8dbc',
	  label: 'Direct Referrals Sale',
	  steps: true,
	  zero: true
    }
    var line_data2 = {
      data : <?php echo $line_chart_binary;?>,
      color: '#00c0ef',
	  label: 'Binary Referrals Sale',
	  steps: true,
	  zero: true
    }
	var line_data3 = {
      data : <?php echo $bar_chart_income;?>,
      color: '#28a745',
	  label: 'Income',
	  steps: true,
	  zero: true
    }
	
    $.plot('#line-chart', [line_data1, line_data2, line_data3], {
      grid  : {
        ledgends  : true,
        hoverable  : true,
        borderColor: '#f3f3f3',
        borderWidth: 1,
        tickColor  : '#f3f3f3'
      },
      series: {
        shadowSize: 0,
        lines     : {
          show: true
        },
        points    : {
          show: true
        }
      },
      lines : {
        fill : false,
        color: ['#3c8dbc', '#f56954']
      },
      yaxis : {
        show: true,
		
      },
	  ////////////

	  ////////////
      xaxis : {
        show: true,
		ticks: <?php echo $line_chart_months;?>,
		
      }
    })
    //Initialize tooltip on hover
     $('<div class="tooltip-inner" id="line-chart-tooltip"></div>').css({
      position: 'absolute',
      display : 'none',
      opacity : 0.8
    }).appendTo('body')
	
    $('#line-chart').bind('plothover', function (event, pos, item) {

      if (item) {
		  console.log(item);
        var x = item.datapoint[0].toFixed(2),
            y = item.datapoint[1].toFixed(2)

        $('#line-chart-tooltip').html(item.series.label + ' = $' + y)
          .css({
            top : item.pageY + 5,
            left: item.pageX + 5
          })
          .fadeIn(200)
      } else {
        $('#line-chart-tooltip').hide()
      }

    }) 
    /* END LINE CHART */

    

    /*
     * BAR CHART
     * ---------
     */

    /* var bar_data = {
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
    }) */
    /* END BAR CHART */

    

  })

  
</script>