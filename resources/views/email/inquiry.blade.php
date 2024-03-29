<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:v="urn:schemas-microsoft-com:vml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
	<meta name="viewport" content="width=600,initial-scale = 2.3,user-scalable=no">
	<link href='https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700' rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Quicksand:300,400,700' rel="stylesheet">
	<!-- <![endif]-->

	<title>VIP Coupon System</title>

	<style type="text/css">
		body {
			width: 100%;
			background-color: #ffffff;
			margin: 0;
			padding: 0;
			-webkit-font-smoothing: antialiased;
			mso-margin-top-alt: 0px;
			mso-margin-bottom-alt: 0px;
			mso-padding-alt: 0px 0px 0px 0px;
		}

		p,
		h1,
		h2,
		h3,
		h4 {
			margin-top: 0;
			margin-bottom: 0;
			padding-top: 0;
			padding-bottom: 0;
		}

		span.preheader {
			display: none;
			font-size: 1px;
		}

		html {
			width: 100%;
		}

		table {
			font-size: 14px;
			border: 0;
		}

		.approve-btn {
		
			background-color:#4caf50 !important;
			border-color:#4caf50 !important;
			color: #fff; 
			text-decoration: none;
		}

		.approve-td {
			color: #00A65A; 
			font-size: 14px; 
			font-family: 'Work Sans', Calibri, sans-serif; 
			line-height: 26px;
		}

		.approve-td div {
			line-height: 26px;
		}
		.deny-btn {
			padding:1em 2em 1em 2em;
			background-color:#DD4B39 !important;
			border-color:#DD4B39 !important;
			color: #fff;
			text-decoration: none;
		}
		/* ----------- responsivity ----------- */

		@media only screen and (max-width: 640px) {
			/*------ top header ------ */
			.main-header {
				font-size: 20px !important;
			}
			.main-section-header {
				font-size: 28px !important;
			}
			.show {
				display: block !important;
			}
			.hide {
				display: none !important;
			}
			.align-center {
				text-align: center !important;
			}
			.no-bg {
				background: none !important;
			}
			/*----- main image -------*/
			.main-image img {
				width: 440px !important;
				height: auto !important;
			}
			/* ====== divider ====== */
			.divider img {
				width: 440px !important;
			}
			/*-------- container --------*/
			.container590 {
				width: 440px !important;
			}
			.container580 {
				width: 400px !important;
			}
			.main-button {
				width: 220px !important;
			}
			/*-------- secions ----------*/
			.section-img img {
				width: 320px !important;
				height: auto !important;
			}
			.team-img img {
				width: 100% !important;
				height: auto !important;
			}
		}

		@media only screen and (max-width: 479px) {
			/*------ top header ------ */
			.main-header {
				font-size: 18px !important;
			}
			.main-section-header {
				font-size: 26px !important;
			}
			/* ====== divider ====== */
			.divider img {
				width: 280px !important;
			}
			/*-------- container --------*/
			.container590 {
				width: 280px !important;
			}
			.container590 {
				width: 280px !important;
			}
			.container580 {
				width: 260px !important;
			}
			/*-------- secions ----------*/
			.section-img img {
				width: 280px !important;
				height: auto !important;
			}
		}
	</style>
</head>


<body class="respond" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">


	<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">

		<tr>
			<td align="center">
				<table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
					<tr>
						<td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
					</tr>
					<tr>
						<td align="center" style="color: #343434; font-family: Quicksand, Calibri, sans-serif;"
							class="main-header">
                            <div style="font-weight:700; font-size:24px;letter-spacing:3px;">Isuzu Traviz Service Campaign</div>
                            <div style="font-weight:700; font-size:14px;">(Turbocharger Oil Pipe with Bracket Replacement)</div>
						</td>
					</tr>

					<tr>
						<td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
					</tr>

                    <tr>
						<td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
					</tr>

					<tr>
						<td>
							<span style="font-weight:bold;">Customer information</span>
							<ul>
								<li> Registered owner : <?php echo $details->registered_owner; ?> </li>
								<li> Contact person : <?php echo $details->contact_person; ?> </li>
								<li> Contact number : <?php echo $details->contact_number; ?> </li>
								<li> Email addrress : <?php echo $details->email_address; ?> </li>
								<li> Preferred servicing dealer : <?php echo ucfirst(strtolower($details->account_name)); ?> </li>
							</ul>
						</td>
					</tr>
					<tr>
						<td>
							<span style="font-weight:bold;">Vehicle information</span>
							<ul>
								<li> VIN : <?php echo $details->vin; ?> </li>
								<li> CS No. : <?php echo $details->cs_no; ?> </li>
								<li> Engine No. : <?php echo $details->engine_no; ?> </li>
								<li> Selling Dealer : <?php echo $details->selling_dealer; ?> </li>
							</ul>
						</td>
					</tr>
		
                    <tr>
						<td height="25" style="font-size: 14px; line-height: 25px;">
						Important Reminder : Kindly acknowledge the customer inquiry within the day.
                        </td>
					</tr>
				
					
				


				</table>
			</td>
		</tr>

	</table>
</body>
</html>