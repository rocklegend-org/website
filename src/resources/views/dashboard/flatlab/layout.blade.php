<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>{{ 'rocklegend :: '.(isset($pageTitle) ? $pageTitle : 'dashboard') }}</title>

		<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Roboto:400,500,700' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=PT+Sans:700,400' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Pontano+Sans' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600' rel='stylesheet' type='text/css'>

		<!-- Styles -->
		{{ HTML::style('assets/css/dashboard/_vendors/font_awesome/font-awesome.css') }}
		{{ HTML::style('assets/css/dashboard/_vendors/various/bootstrap.min.css') }}

		{{ HTML::style('assets/css/dashboard/_vendors/various/nv.d3.css') }}<!-- VISITOR CHART -->
		{{ HTML::style('assets/css/dashboard/_vendors/various/daterangepicker-bs3.css') }}<!-- Date Range Picker -->

		{{ HTML::style('assets/css/dashboard/flatlab.css') }}<!-- Style -->

		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		{{ HTML::script('assets/js/jquery.form.js') }}

		{{ HTML::script('assets/js/dashboard/d3.v2.js') }}<!-- VISITOR CHART -->
		{{ HTML::script('assets/js/dashboard/nv.d3.js') }}<!-- VISITOR CHART -->
		{{ HTML::script('assets/js/dashboard/live-updating-chart.js') }}<!-- VISITOR CHART -->
		{{ HTML::script('assets/js/dashboard/bootstrap.min.js') }}<!-- Bootstrap -->
		{{ HTML::script('assets/js/dashboard/script.js') }}<!-- Script -->

		{{ HTML::script('assets/js/dashboard/skycons.js') }}<!-- Skycons -->
		{{ HTML::script('assets/js/dashboard/enscroll-0.5.2.min.js') }}<!-- Custom Scroll bar -->
		{{ HTML::script('assets/js/dashboard/moment.js') }}<!-- Date Range Picker -->
		{{ HTML::script('assets/js/dashboard/daterangepicker.js') }}<!-- Date Range Picker -->
		{{ HTML::script('assets/js/dashboard/carousal-plugins.js') }}<!-- Carousal Widget -->
		{{ HTML::script('assets/js/dashboard/ticker.js') }}<!-- Ticker -->


	</head>
	<body class="{{ $bodyClass ?? ''}}">
		@section('responsive.menu')
		<div class="responsive-menu">
				<div class="responsive-menu-dropdown blue">
					<a title="" class="blue">MENU <i class="fa fa-align-justify" ></i></a>
				</div>
				<ul>
				<li id="intro4"><a href="#" title="" ><i class="fa fa-desktop"></i><span><i>4</i></span>Discover</a>
					<ul>
						<li><a href="dashboard.html" title="">Dashboard 1</a></li>
						<li><a href="dashboard2.html" title="">Dashboard 2</a></li>
						<li><a href="dashboard3.html" title="">Dashboard 3</a></li>
						<li><a href="dashboard4.html" title="">Dashboard 4</a></li>
					</ul>
				</li>
				<li id="intro5"><a href="widget.html" title="" ><i class="fa fa-heart-o"></i><span><i>20+</i></span>Widget</a></li>
				<li><a href="#" title="" ><i class="fa fa-tint"></i><span><i>12</i></span>Ui Kit</a>
					<ul>
						<li><a href="notifications.html" title="">Notifications</a></li>
						<li><a href="grids.html" title="">Grids</a></li>
						<li><a href="buttons.html" title="">Buttons</a></li>
						<li><a href="calendars.html" title="">Calendars</a></li>
						<li><a href="file-manager.html" title="">File Manager</a></li>
						<li><a href="gallery.html" title="">Gallery</a></li>
						<li><a href="slider.html" title="">Slider</a></li>
						<li><a href="page-tour.html" title="">Page Tour</a></li>
						<li><a href="collapse.html" title="">Collapse</a></li>
						<li><a href="range-slider.html" title="">Range Slider</a></li>
						<li><a href="typography.html" title="">Typography</a></li>
						<li><a href="tables.html" title="">Tables</a></li>

					</ul>
				</li>
				<li><a href="form.html" title="" ><i class="fa fa-paperclip"></i>Form Stuff</a></li>
				<li><a href="charts.html" title="" ><i class="fa fa-unlink"></i><span><i>5+</i></span>Charts</a></li>
				<li><a href="#" title="" ><i class="fa fa-rocket"></i><span><i>8+</i></span>Pages</a>
					<ul>
						<li><a href="invoice.html" title="">Invoice</a></li>
						<li><a href="order-recieved.html" title="">Order Recieved</a></li>
						<li><a href="search-result.html" title="">Search Result</a></li>
						<li><a href="price-table.html" title="">Price Table</a></li>
						<li><a href="inbox.html" title="">Inbox</a></li>
						<li><a href="profile.html" title="">Profile</a></li>
						<li><a href="contact.html" title="">Contact Us</a></li>
						<li><a href="css-spinners.html" title="">Css Spinners</a></li>
					</ul>
				</li>
				<li><a href="#" title="" ><i class="fa fa-thumbs-o-up"></i><span><i>6+</i></span>Bonus</a>
					<ul>

						<li><a href="faq.html" title="">Faq</a></li>
						<li><a href="index.html" title="">Log in</a></li>
						<li><a href="blank.html" title="">blank</a></li>
						<li><a href="cart.html" title="">Cart</a></li>
						<li><a href="billing.html" title="">Billing</a></li>
						<li><a href="icons.html" title="">Icons</a></li>
					</ul>
				</li>
			</ul>
		</div>
		<header>
			<div class="logo">
				<img src="{{ asset('assets/images/dashboard/logo_white.png') }}" alt="" />
			</div>
			<div class="header-post">
				<a href="#add-post-title" data-toggle="modal" title="">POST <i class="fa fa-plus"></i></a>
				<ul>
				<li><a href="#" title="" data-tooltip="Refresh" data-placement="bottom"><i class="fa fa-refresh"></i></a></li>
				<li><a href="#" title="" data-tooltip="Custom" data-placement="bottom"><i class="fa fa-th-large"></i></a></li>
				<li class="upload-files-sec"><a href="#" title="" data-tooltip="Upload Files" data-placement="bottom" class="upload-btn"><i class="fa fa-cloud-upload"></i></a>

				<div class="upload-files">
					<ul>
						<li>
							<p>Photoshop 524.psd</p>
							<div class="progress small-progress progress-striped active">
								<div style="width: 30%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar pink">
								</div>
							</div>
						</li>

						<li>
							<p>Phtoto758.jpg</p>
							<div class="progress small-progress progress-striped active">
								<div style="width: 58%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar yellow">
								</div>
							</div>
						</li>

						<li>
							<p>Private files.xlxs</p>
							<div class="progress small-progress  progress-striped active">
								<div style="width: 32%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar blue">
								</div>
							</div>
						</li>

						<li>
							<p>index.html</p>
							<div class="progress small-progress progress-striped active">
								<div style="width: 98%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar black">
								</div>
							</div>
						</li>

					</ul>
				</div>
				</li>
				</ul>
			</div>
			<div aria-hidden="true" role="dialog" tabindex="-1" class="modal fade" id="add-post-title" style="display: none;">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header blue">
						  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
						  <h4 class="modal-title">Setting Section</h4>
						</div>
						<div class="modal-body">
						  <input type="text" placeholder="TITLE" />
						  <textarea placeholder="DESCRIPTION" rows="5"></textarea>
						</div>
						<div class="modal-footer">
						  <button data-dismiss="modal" class="btn btn-default black" type="button">Close</button>
						  <button class="btn btn-primary blue" type="button">Save changes</button>
						</div>
					</div><!-- /.modal-content -->
				</div>
			</div>
			<div class="header-alert">
				<ul>
					<li><a href="#" title=""><i class="fa fa-group"></i>Team Statistics</a></li>
					<li><a title="" class="message-btn"><i class="fa fa-envelope"></i><span>3</span></a>
						<div class="message">
							<span>You have 3 New Messages</span>
							<a href="#" title=""><img src="http://placehold.it/40x40" alt="" />Hey! How are You Diana. I waiting for you.
							toe Check. <p><i class="fa fa-clock-o"></i>3:45pm</p></a>
							<a href="#" title=""><img src="http://placehold.it/40x40" alt="" />Please Can you Submit A file. I am From Korea
							toe Check. <p><i class="fa fa-clock-o"></i>1:40am</p></a>
							<a href="#" title=""><img src="http://placehold.it/40x40" alt="" />Hey Today is Party So you Will Have to Come <p><i class="fa fa-clock-o"></i>4 Hours ago</p></a>
							<a href="inbox.html" class="view-all">VIEW ALL MESSAGE</a>
						</div>


					</li>
					<li><a title="" class="notification-btn"><i class="fa fa-bell"></i><span>4</span></a>
						<div class="notification">
							<span>You have 6 New Notification</span>
							<a href="#" title=""><img src="http://placehold.it/40x40" alt="" />Server 3 is Over Loader Pleas
							toe Check. <p><i class="fa fa-clock-o"></i>3:45pm</p></a>
							<a href="#" title=""><img src="http://placehold.it/40x40" alt="" />Server 10 is Over Loader Pleas
							toe Check. <p><i class="fa fa-clock-o"></i>1:40am</p></a>
							<a href="#" title=""><img src="http://placehold.it/40x40" alt="" />New User Registered Please Check This <p><i class="fa fa-clock-o"></i>4 Hours ago</p></a>
							<a href="#" class="view-all">VIEW ALL NOTIFICATIONS</a>
						</div>

					</li>
				</ul>
			</div>
			<div class="right-bar-sec">
				<a href="#" title="" class="right-bar-btn"><i class="fa fa-bars rotator animation"></i></a>
				<a href="#" title="" class="right-bar-btn-mobile"><i class="fa fa-bars rotator animation"></i></a>
				<div id="scrollbox4" class="right-bar">

					<div class="my-account">
						<form>
							<input type="text" placeholder="SEARCH ACCOUNT" />
							<a href="" title="" data-tooltip="Account" data-placement="left"><i class="fa fa-cogs"></i></a>
						</form>
						<a id="account" class="toogle-head">ACCOUNT LIST<i class="fa fa-plus"></i></a>
						<div class="account2">
							<ul>
								<li>
								Private Office
									<div class="switch-account">
									  <input type="checkbox" id="check"/>
									  <label for="check" class="switch">
										<span class="slide-account"></span>
									  </label>
									</div>
								</li>
								<li>
								Home Account
									<div class="switch-account">
										<input type="checkbox" id="check2" checked/>
									  <label for="check2" class="switch">
										<span class="slide-account"></span>
									  </label>
									</div>
								</li>
								<li>
								Personal Account
									<div class="switch-account">
										<input type="checkbox" id="check3" checked/>
									  <label for="check3" class="switch">
										<span class="slide-account"></span>
									  </label>
									</div>
								</li>
							</ul>

						<a href="#" title=""><i class="fa fa-plus"></i>ADD ACCOUNT</a>
						</div>
					</div><!-- Add Account -->

					<div class="users-online">
						<a id="user-online" class="toogle-head">USERS ONLINE<i class="fa fa-plus"></i><span>26</span></a>
						<div class="user-online2">
							<ul>
								<li><img src="http://placehold.it/32x32" alt="" /><h5><a href="#" title="">Johny Razell</a></h5><span class="offline">OFFLINE</span> </li>
								<li><img src="http://placehold.it/32x32" alt="" /><h5><a href="#" title="">John Smith</a></h5><span class="online">ONLINE</span> </li>
								<li><img src="http://placehold.it/32x32" alt="" /><h5><a href="#" title="">Doe Haxzer</a></h5><span class="online">ONLINE</span> </li>
								<li><img src="http://placehold.it/32x32" alt="" /><h5><a href="#" title="">Karen Kelly</a></h5><span class="unread"><i>4</i></span>
								<p>Hey! I am still waitin</p>
								</li>
							</ul>
						<a href="#" title="" ><i>260</i>TOTAL MEMBER</a>
						</div>
					</div><!-- Users Online -->


					<div class="disk-usage-sec">
						<a id="disk-usage" class="toogle-head">USAGE<i class="fa fa-plus"></i></a>
						<div class="disk-usage">
							<p>1.31 GB of 1.50 GB used <i>75%</i></p>
							<div class="progress small-progress">
								<div style="width: 35%" class="progress-bar black">
								  <span class="sr-only">35% Complete (success)</span>
								</div>
								<div style="width: 20%" class="progress-bar blue">
								  <span class="sr-only">20% Complete (warning)</span>
								</div>
								<div style="width: 10%" class="progress-bar pink">
								  <span class="sr-only">10% Complete (danger)</span>
								</div>
							</div>
						</div>
					</div><!-- Disk Usage -->


					<div class="pending-task-sec">
						<a id="pending-task" class="toogle-head">PENDING TASK<i class="fa fa-plus"></i></a>
						<div class="pending-task">
							<ul>
								<li><h6>Development</h6><span>75%</span><a href="#" title="" data-tooltip="Refresh" data-placement="left"><i class="fa fa-refresh"></i></a>
									<div class="progress small-progress">
										<div style="width: 40%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar pink">
										</div>
									</div>
								</li>

								<li><h6>Bug Fixes</h6><span>60%</span><a href="#" title="" data-tooltip="Refresh" data-placement="top"><i class="fa fa-refresh"></i></a>
									<div class="progress small-progress">
										<div style="width: 60%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar blue">
										</div>
									</div>
								</li>

								<li><h6>Javascript</h6><span>90%</span><a href="#" title="" data-tooltip="Refresh" data-placement="bottom"><i class="fa fa-refresh"></i></a>
									<div class="progress small-progress">
										<div style="width: 90%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar black">
										</div>
									</div>
								</li>


							</ul>
						</div>
					</div><!-- Disk Usage -->


				</div><!-- Right Bar -->
			</div><!-- Right Bar Sec -->
		</header><!-- Header -->

		<div class="menu">
			<div class="menu-profile" id="intro3">
				<img src="http://placehold.it/57x57" alt="" />
				<span><i class="fa fa-plus"></i></span>
				<div class="menu-profile-hover">
					<h1><i>Brian</i> Kelly</h1>
					<p><i class="fa fa-map-marker"></i>LONDON, UNITED KINGDOM</p>
					<a href="index.html" title=""><i class="fa fa-power-off"></i></a>
					<div class="menu-profile-btns">

					<h3>
						<i class="fa fa-user blue"></i>
						<a href="profile.html" title="">PROFILE</a>
					</h3>
					<h3>
						<i class="fa fa-inbox pink"></i>
						<a href="inbox.html" title="">INBOX</a>
					</h3>


					</div>
				</div>
			</div>
			<ul>
				<li><a href="#" title="" ><i class="fa fa-desktop"></i>Discover</a>
					<ul>
						<li><a href="dashboard.html" title="">Dashboard 1</a></li>
						<li><a href="dashboard2.html" title="">Dashboard 2</a></li>
						<li><a href="dashboard3.html" title="">Dashboard 3</a></li>
						<li><a href="dashboard4.html" title="">Dashboard 4</a></li>
					</ul>
				</li>
				<li><a href="widget.html" title="" ><i class="fa fa-heart-o"></i><span><i>20+</i></span>Widget</a></li>
				<li><a href="#" title="" ><i class="fa fa-tint"></i>Ui Kit</a>
					<ul>
						<li><a href="notifications.html" title="">Notifications</a></li>
						<li><a href="grids.html" title="">Grids</a></li>
						<li><a href="buttons.html" title="">Buttons</a></li>
						<li><a href="calendars.html" title="">Calendars</a></li>
						<li><a href="file-manager.html" title="">File Manager</a></li>
						<li><a href="gallery.html" title="">Gallery</a></li>
						<li><a href="slider.html" title="">Slider</a></li>
						<li><a href="page-tour.html" title="">Page Tour</a></li>
						<li><a href="collapse.html" title="">Collapse</a></li>
						<li><a href="range-slider.html" title="">Range Slider</a></li>
						<li><a href="typography.html" title="">Typography</a></li>
						<li><a href="tables.html" title="">Tables</a></li>

					</ul>
				</li>
				<li><a href="form.html" title="" ><i class="fa fa-paperclip"></i>Form Stuff</a></li>
				<li><a href="charts.html" title="" ><i class="fa fa-unlink"></i>Charts</a></li>
				<li><a href="#" title="" ><i class="fa fa-rocket"></i>Pages</a>
					<ul>
						<li><a href="invoice.html" title="">Invoice</a></li>
						<li><a href="order-recieved.html" title="">Order Recieved</a></li>
						<li><a href="search-result.html" title="">Search Result</a></li>
						<li><a href="price-table.html" title="">Price Table</a></li>
						<li><a href="inbox.html" title="">Inbox</a></li>
						<li><a href="profile.html" title="">Profile</a></li>
						<li><a href="contact.html" title="">Contact Us</a></li>
						<li><a href="css-spinners.html" title="">Css Spinners</a></li>
					</ul>
				</li>
				<li><a href="#" title="" ><i class="fa fa-thumbs-o-up"></i>Bonus</a>
					<ul>

						<li><a href="faq.html" title="">Faq</a></li>
						<li><a href="index.html" title="">Log in</a></li>
						<li><a href="blank.html" title="">blank</a></li>
						<li><a href="cart.html" title="">Cart</a></li>
						<li><a href="billing.html" title="">Billing</a></li>
						<li><a href="icons.html" title="">Icons</a></li>
					</ul>
				</li>
			</ul>
		</div><!-- Right Menu -->
		@stop
		@yield('responsive.menu')

		<div class="wrapper">
			<div class="container">
				@yield('content')
			</div><!-- Container -->
		</div><!-- Wrapper -->
	</body>
</html>