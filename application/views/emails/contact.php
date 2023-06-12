
<body>

            <table class="body-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #eaf0f7; margin: 0;" bgcolor="#eaf0f7">
                <tr>
                    <td class="container" width="600" style="margin:0 auto; display: block !important; max-width: 600px !important; clear: both !important;" valign="top">
                        <div class="content" style="padding: 50px 0;">
                            <table class="main" width="100%" cellpadding="0" cellspacing="0" style="border: 1px solid #e9e9e9;" bgcolor="#fff">
                                <tr>
                                    <td class="alert alert-primary border-0 bg-primary" style="background-color: #5867dd;padding: 20px; border-radius: 0;" align="center" valign="top"><img src="<?php echo base_url($this->general->get_system_var('logo_img'));?>" alt="image" style="margin-left: auto; margin-right: auto; display:block;height: 60px;"></td>
                                </tr>
								
                                <tr>
                                    <td class="alert alert-dark border-0" style="color:#ffffff; background-color: #949494; padding: 20px; border-radius: 0;" align="center" valign="top"><?php echo $subject;?></td>
                                </tr>
								<tr>
                                    <td class="alert alert-dark border-0" style="color:#525252; background-color: #d4d5d8; padding: 20px; border-radius: 0;" align="center" valign="top"><?php echo 'Name: '.$name.'<br>'.'Email: '.$email;?></td>
                                </tr>
                                <tr>
                                    <td class="content-wrap" style="padding: 20px;" valign="top">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            
                                            <tr>
                                                <td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; padding: 10px 10px 20px;white-space: pre;" valign="top"><?php echo $message;?></td>
                                            </tr>
                                            
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
                </tr>
            </table>
            

</body>
