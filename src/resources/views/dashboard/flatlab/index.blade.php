@extends('dashboard/flatlab/layout')

@section('content')

<div class="col-md-6">
	<div class="heading-sec">
		<h1>Dashboard <i>Welcome to Flat Lab</i></h1>
	</div>
</div>
<div class="col-md-6">
	<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
      <i class="fa fa-calendar-o icon-calendar icon-large"></i>
      <span></span> <b class="caret"></b>
   </div>
</div>


<div class="col-md-12">
	<div class="visitor-stats widget-body blue">
		<h6>
			WEDNESDAY
			<i>APRIL / 2013</i>
		</h6>
		<span>24%
		<i>VISITOR</i>
		</span>
		<div id="chart">
			<svg />
		</div>
		<p>+ 16,582,00</p>
	</div>
		<div class="chart-tab">
			<div id="tabs-container">
				<div class="tab">
					<div id="tab-1" class="tab-content">
						<p>NEW </p>
						<div class="progress small-progress">
							<div style="width: 70%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar blue">
							</div>
						</div>

						<p>LAST WEEK </p>
						<div class="progress small-progress">
							<div style="width: 40%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar black">
							</div>
						</div>

						<p>THIS MONTH</p>
						<div class="progress small-progress">
							<div style="width: 76%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar black">
							</div>
						</div>
					</div>
					<div id="tab-2" class="tab-content">
															<p>NEW </p>
						<div class="progress small-progress">
							<div style="width: 20%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar blue">
							</div>
						</div>

						<p>LAST WEEK </p>
						<div class="progress small-progress">
							<div style="width: 90%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar black">
							</div>
						</div>

						<p>THIS MONTH</p>
						<div class="progress small-progress">
							<div style="width: 12%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar black">
							</div>
						</div>

					</div>
					<div id="tab-3" class="tab-content">
															<p>NEW </p>
						<div class="progress small-progress">
							<div style="width: 50%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar blue">
							</div>
						</div>

						<p>LAST WEEK </p>
						<div class="progress small-progress">
							<div style="width: 80%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar black">
							</div>
						</div>

						<p>THIS MONTH</p>
						<div class="progress small-progress">
							<div style="width: 49%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar black">
							</div>
						</div>
					</div>
				</div>
			</div>
				<ul class="tabs-menu">
					<li class="current"><a href="#tab-1">NEW VISITORS</a></li>
					<li><a href="#tab-2">RETURNING</a></li>
					<li><a href="#tab-3">LAST WEEK</a></li>
				</ul>
		</div>
</div><!-- Widget Visitor -->

<div class="col-md-4">
	<div class="follow-widget widget-body">
		<div class="follow-widget-head blue">
			<img src="http://placehold.it/104x104" alt="" />
			<h2><i>BRIAN</i> KELLY</h2>
			<Span>@briankelly</span>
			<a href="#" title=""><i class="fa fa-twitter"></i>FOLLOW</a>
		</div>
		<ul>
			<li><a href="#" title=""><i class="fa fa-heart-o"></i>1,250</a></li>
			<li><a href="#" title=""><i class="fa fa-thumbs-o-up"></i>9,340</a></li>
			<li><a href="#" title=""><i class="fa fa-comments-o"></i>2,041</a></li>
		</ul>
	</div>
</div><!-- Follow Widget -->

<div class="col-md-4">
	<div class="contact-list widget-body">
		<div class="contact-list-head pink">
			<p>A COMPLETE CONTACT LIST</p>
			<ul>
				<li><a href="#" title=""><i class="fa fa-facebook"></i></a></li>
				<li><a href="#" title=""><i class="fa fa-twitter"></i></a></li>
				<li><a href="#" title=""><i class="fa fa-google-plus"></i></a></li>

			</ul>
		</div>
		<ul id="scrollbox5">
			<li><img src="http://placehold.it/45x45" alt="" /><a href="#" title="">Brian Craft</a>
			<p><i class="fa fa-map-marker"></i>DUBAI</p>
			<span><i class="fa fa-cog"></i></span>
			<div class="choose-contact">
				<a href="#" title=""><i class="fa fa-phone"></i></a>
				<a href="#" title=""><i class="fa fa-skype"></i></a>
				<a href="#" title=""><i class="fa fa-cog"></i></a>
			</div>
			</li>
			<li><img src="http://placehold.it/45x45" alt="" /><a href="#" title="">Brian Craft</a>
			<p><i class="fa fa-map-marker"></i>DUBAI</p>
			<span><i class="fa fa-cog"></i></span>
			<div class="choose-contact">
				<a href="#" title=""><i class="fa fa-phone"></i></a>
				<a href="#" title=""><i class="fa fa-skype"></i></a>
				<a href="#" title=""><i class="fa fa-cog"></i></a>
			</div>
			</li>
			<li><img src="http://placehold.it/45x45" alt="" /><a href="#" title="">Brian Craft</a>
				<p><i class="fa fa-map-marker"></i>DUBAI</p>
				<span><i class="fa fa-cog"></i></span>
				<div class="choose-contact">
					<a href="#" title=""><i class="fa fa-phone"></i></a>
					<a href="#" title=""><i class="fa fa-skype"></i></a>
					<a href="#" title=""><i class="fa fa-cog"></i></a>
				</div>
			</li>
			<li><img src="http://placehold.it/45x45" alt="" /><a href="#" title="">Brian Craft</a>
				<p><i class="fa fa-map-marker"></i>DUBAI</p>
				<span><i class="fa fa-cog"></i></span>
				<div class="choose-contact">
					<a href="#" title=""><i class="fa fa-phone"></i></a>
					<a href="#" title=""><i class="fa fa-skype"></i></a>
					<a href="#" title=""><i class="fa fa-cog"></i></a>
				</div>
			</li>
			<li><img src="http://placehold.it/45x45" alt="" /><a href="#" title="">Brian Craft</a>
				<p><i class="fa fa-map-marker"></i>DUBAI</p>
				<span><i class="fa fa-cog"></i></span>
				<div class="choose-contact">
					<a href="#" title=""><i class="fa fa-phone"></i></a>
					<a href="#" title=""><i class="fa fa-skype"></i></a>
					<a href="#" title=""><i class="fa fa-cog"></i></a>
				</div>
			</li>
			<li><img src="http://placehold.it/45x45" alt="" /><a href="#" title="">Brian Craft</a>
				<p><i class="fa fa-map-marker"></i>DUBAI</p>
				<span><i class="fa fa-cog"></i></span>
				<div class="choose-contact">
					<a href="#" title=""><i class="fa fa-phone"></i></a>
					<a href="#" title=""><i class="fa fa-skype"></i></a>
					<a href="#" title=""><i class="fa fa-cog"></i></a>
				</div>
			</li>
			<li><img src="http://placehold.it/45x45" alt="" /><a href="#" title="">Brian Craft</a>
				<p><i class="fa fa-map-marker"></i>DUBAI</p>
				<span><i class="fa fa-cog"></i></span>
				<div class="choose-contact">
					<a href="#" title=""><i class="fa fa-phone"></i></a>
					<a href="#" title=""><i class="fa fa-skype"></i></a>
					<a href="#" title=""><i class="fa fa-cog"></i></a>
				</div>
			</li>
		</ul>
	</div>
</div><!-- Contact list Widget -->


<div class="col-md-4">
	<div class="carousal-widget widget-body black">
		<div class="slidewrap" data-autorotate="5000">
			<ul class="slider" id="sliderName">
				<li class="slide1">
					<p><i>Steve Jobs</i> Time Capsu le` is Fialinlyo But Why Unearthed on <i>Skyace News</i></p>
					<a href="#" title="">VIEW ALL</a>
				</li>
				<li class="slide1">
					<p>Steve Jobs Time Capsu le` is Fialinlyo Unearthed  But Why  on <i>Skyace News</i></p>
					<a href="#" title="">VIEW ALL</a>
				</li>
				<li class="slide1">
					<p>Steve Jobs Time Capsu le` is Fialinlyo Unearthed on But Why  <i>Skyace News</i></p>
					<a href="#" title="">VIEW ALL</a>
				</li>
				<li class="slide1">
					<p>Steve Jobs Time Capsu le` is Fialinlyo Unearthed on  But Why <i>Skyace News</i></p>
					<a href="#" title="">VIEW ALL</a>
				</li>
				<li class="slide1">
					<p>Steve Jobs Time Capsu le` is Fialinlyo Unearthed on But Why  <i>Skyace News</i></p>
					<a href="#" title="">VIEW ALL</a>
				</li>
			</ul>

			<ul class="slidecontrols">
				<li><a href="#sliderName" class="prev"><i class="fa fa-angle-left"></i></a></li>
				<li><a href="#sliderName" class="next"><i class="fa fa-angle-right"></i></a></li>
			</ul>

		</div>
	</div>
</div><!-- Carousal Widget -->


<div class="col-md-4">
	<div class="follow-me-widget widget-body">
		<div class="follow-me-thumb">
			<img src="http://placehold.it/95x85" alt="" />
			<a href="#" title="">FOLLOW</a>
		</div>
		<div class="follow-me-details">
			<a href="#" title="">@Mike Mcalidek</a>
			<span>2,415 followers / 225 tweets</span>
			<p>Twitter loerm salan dil  Dnim eius mod toson life accusamus.  </p>
		</div>
	</div>
</div><!-- Follow Me Widget -->



<div class="col-md-4">
	<div class="stat-boxes widget-body">
		<span class="fa fa-shopping-cart black"></span>
		<h3 class="ticker--one">57</h3>
		<i>NEW ORDERS</i>

	</div>
</div>

<div class="col-md-4">
	<div class="stat-boxes widget-body">
		<span class="fa fa-usd green"></span>
		<h3 class="ticker--two">946</h3>
		<i>NEW SALES</i>

	</div>
</div>

<div class="col-md-4">
	<div class="stat-boxes widget-body real-time">
		<h3>36</h3>
		<i>REAL TIME</i>

	</div>
</div>


<div class="col-md-6">
	<div class="chat-widget widget-body">
		<div class="chat-widget-head yellow">
			<h4>Chat Widget</h4>
			<div class="add-btn">
				<a href="#" title=""><i class="fa fa-plus pink"></i>ADD USER</a>
			</div>
		</div>
		<ul id="scrollbox6">
			<li>
				<div class="chat-thumb"><img src="http://placehold.it/61x61" alt="" /></div>
				<div class="chat-desc">
					<p>Hi John, What's up...Lorem ipsum dolor is Fialinlyo Unearthed on sit amet, conse adipiscing eli...</p>
					<i class="chat-time">2:45 AM</i>
				</div>
			</li>

			<li class="reply">
				<div class="chat-thumb"><img src="http://placehold.it/61x61" alt="" /></div>
				<div class="chat-desc">
					<p>Hi John, What's up...Lorem is Fialinlyo Unearthed on ipsum dolor sit amet, conse adipiscing eli...</p>
					<i class="chat-time">2:45 AM</i>
				</div>
			</li>

			<li>
				<div class="chat-thumb"><img src="{{ asset('assets/images/dashboard/chat2.jpg') }}" alt="" /></div>
				<div class="chat-desc">
					<p>Hi John, What's up...Lorem is Fialinlyo Unearthed on ipsum dolor sit amet, conse adipiscing eli...</p>
					<i class="chat-time">2:45 AM</i>
				</div>
			</li>

			<li class="reply">
				<div class="chat-thumb"><img src="http://placehold.it/61x61" alt="" /></div>
				<div class="chat-desc">
					<p>Hi John, What's up...Lorem ipsum dolor is Fialinlyo Unearthed on sit amet, conse adipiscing eli...</p>
					<i class="chat-time">2:45 AM</i>
				</div>
			</li>

			<li>
				<div class="chat-thumb"><img src="http://placehold.it/61x61" alt="" /></div>
				<div class="chat-desc">
					<p>Hi John, is Fialinlyo Unearthed on What's up...Lorem ipsum dolor sit amet, conse adipiscing eli...</p>
					<i class="chat-time">2:45 AM</i>
				</div>
			</li>
			<li class="reply">
				<div class="chat-thumb"><img src="http://placehold.it/61x61" alt="" /></div>
				<div class="chat-desc">
					<p>Hi John, What's up...Lorem ipsum dolor is Fialinlyo Unearthed on sit amet, conse adipiscing eli...</p>
					<i class="chat-time">2:45 AM</i>
				</div>
			</li>

			<li>
				<div class="chat-thumb"><img src="http://placehold.it/61x61" alt="" /></div>
				<div class="chat-desc">
					<p>Hi John, is Fialinlyo Unearthed on What's up...Lorem ipsum dolor sit amet, conse adipiscing eli...</p>
					<i class="chat-time">2:45 AM</i>
				</div>
			</li>
			<li class="reply">
				<div class="chat-thumb"><img src="http://placehold.it/61x61" alt="" /></div>
				<div class="chat-desc">
					<p>Hi John, What's up...Lorem ipsum dolor is Fialinlyo Unearthed on sit amet, conse adipiscing eli...</p>
					<i class="chat-time">2:45 AM</i>
				</div>
			</li>

			<li>
				<div class="chat-thumb"><img src="http://placehold.it/61x61" alt="" /></div>
				<div class="chat-desc">
					<p>Hi John, is Fialinlyo Unearthed on What's up...Lorem ipsum dolor sit amet, conse adipiscing eli...</p>
					<i class="chat-time">2:45 AM</i>
				</div>
			</li>
			<li class="reply">
				<div class="chat-thumb"><img src="http://placehold.it/61x61" alt="" /></div>
				<div class="chat-desc">
					<p>Hi John, What's up...Lorem ipsum dolor is Fialinlyo Unearthed on sit amet, conse adipiscing eli...</p>
					<i class="chat-time">2:45 AM</i>
				</div>
			</li>

			<li>
				<div class="chat-thumb"><img src="http://placehold.it/61x61" alt="" /></div>
				<div class="chat-desc">
					<p>Hi John, is Fialinlyo Unearthed on What's up...Lorem ipsum dolor sit amet, conse adipiscing eli...</p>
					<i class="chat-time">2:45 AM</i>
				</div>
			</li>
		</ul>
		<div class="reply-sec">
			<a href="#" title=""><i class="fa fa-location-arrow"></i></a>
			<a href="#" title=""><i class="fa fa-microphone"></i></a>
			<a href="#" title=""><i class="fa fa-camera"></i></a>
			<a href="#" title=""><i class="fa fa-cloud-upload"></i></a>
			<form>
				<input type="text" placeholder="TYPE YOUR MESSAGE HERE" />
				<a href="#" title="" class="black"><i class="fa fa-comments-o"></i></a>

			</form>
		</div>
	</div>
</div><!-- Chat Widget -->


<div class="col-md-6">
	<div class="inbox-widget widget-body">
		<div class="inbox-widget-head black">
			<div>
				<img src="http://placehold.it/103x103" alt="" />
			</div>
			<h6><i>MIKE</i> MCALIDEK</h6>
			<span><i class="fa fa-map-marker"></i>ABU DHABI</span>
			<p>Lorem ipsum dolor sit amet, conse adipiscing. dolor sit amet, conse
			adipiscing.</p>
		</div>

		<ul id="scrollbox7" class="your-message">
			<li><img src="http://placehold.it/50x50" alt="" />
				<span>1 min ago</span><i>By Mike</i>
				<p>Lorem ipsum dolor sit amet, conse adipiscing. dolor sit amet, conse adip.</p>
				<div class="inbox-hover black">
					<a href="#" title="" data-tooltip="Read" data-placement="bottom"><i class="fa fa-eye"></i></a>
					<a href="#" title="" data-tooltip="Delete" data-placement="bottom"><i class="fa fa-trash-o"></i></a>
					<a href="#" title="" data-tooltip="Important" data-placement="bottom"><i class="fa fa-star-o"></i></a>
				</div>
			</li>
			<li><img src="http://placehold.it/50x50" alt="" />
				<span>1 min ago</span><i>By Mike</i>
				<p>Lorem ipsum dolor sit amet, conse adipiscing. dolor sit amet, conse adip.</p>
				<div class="inbox-hover black">
					<a href="#" title="" data-tooltip="Read" data-placement="bottom"><i class="fa fa-eye"></i></a>
					<a href="#" title="" data-tooltip="Delete" data-placement="bottom"><i class="fa fa-trash-o"></i></a>
					<a href="#" title="" data-tooltip="Important" data-placement="bottom"><i class="fa fa-star-o"></i></a>
				</div>
			</li>
			<li><img src="http://placehold.it/50x50" alt="" />
				<span>1 min ago</span><i>By Mike</i>
				<p>Lorem ipsum dolor sit amet, conse adipiscing. dolor sit amet, conse adip.
ipsum dolor sit amet, conse adipiscing. dolor sit amet, conse adip.</p>
				<div class="inbox-hover black">
					<a href="#" title="" data-tooltip="Read" data-placement="bottom"><i class="fa fa-eye"></i></a>
					<a href="#" title="" data-tooltip="Delete" data-placement="bottom"><i class="fa fa-trash-o"></i></a>
					<a href="#" title="" data-tooltip="Important" data-placement="bottom"><i class="fa fa-star-o"></i></a>
				</div>
			</li>
			<li><img src="http://placehold.it/50x50" alt="" />
				<span>1 min ago</span><i>By Mike</i>
				<p>Lorem ipsum dolor sit amet, conse adipiscing. dolor sit amet, conse adip.Lorem ipsum dolor sit amet, conse adipiscing. dolor sit amet.</p>
				<div class="inbox-hover black">
					<a href="#" title="" data-tooltip="Read" data-placement="bottom"><i class="fa fa-eye"></i></a>
					<a href="#" title="" data-tooltip="Delete" data-placement="bottom"><i class="fa fa-trash-o"></i></a>
					<a href="#" title="" data-tooltip="Important" data-placement="bottom"><i class="fa fa-star-o"></i></a>
				</div>
			</li>
			<li><img src="http://placehold.it/50x50" alt="" />
				<span>1 min ago</span><i>By Mike</i>
				<p>Lorem ipsum dolor sit amet, conse adipiscing. dolor sit amet, conse adip.</p>
				<div class="inbox-hover black">
					<a href="#" title="" data-tooltip="Read" data-placement="bottom"><i class="fa fa-eye"></i></a>
					<a href="#" title="" data-tooltip="Delete" data-placement="bottom"><i class="fa fa-trash-o"></i></a>
					<a href="#" title="" data-tooltip="Important" data-placement="bottom"><i class="fa fa-star-o"></i></a>
				</div>
			</li>
			<li><img src="http://placehold.it/50x50" alt="" />
				<span>1 min ago</span><i>By Mike</i>
				<p>Lorem ipsum dolor sit amet, conse adipiscing. dolor sit amet, conse adip.
ipsum dolor sit amet, conse adipiscing. dolor sit amet, conse adip.</p>
				<div class="inbox-hover black">
					<a href="#" title="" data-tooltip="Read" data-placement="bottom"><i class="fa fa-eye"></i></a>
					<a href="#" title="" data-tooltip="Delete" data-placement="bottom"><i class="fa fa-trash-o"></i></a>
					<a href="#" title="" data-tooltip="Important" data-placement="bottom"><i class="fa fa-star-o"></i></a>
				</div>
			</li>
			<li><img src="http://placehold.it/50x50" alt="" />
				<span>1 min ago</span><i>By Mike</i>
				<p>Lorem ipsum dolor sit amet, conse adipiscing. dolor sit amet, conse adip.Lorem ipsum dolor sit amet, conse adipiscing. dolor sit amet.</p>
				<div class="inbox-hover black">
					<a href="#" title="" data-tooltip="Read" data-placement="bottom"><i class="fa fa-eye"></i></a>
					<a href="#" title="" data-tooltip="Delete" data-placement="bottom"><i class="fa fa-trash-o"></i></a>
					<a href="#" title="" data-tooltip="Important" data-placement="bottom"><i class="fa fa-star-o"></i></a>
				</div>
			</li>
			<li><img src="http://placehold.it/50x50" alt="" />
				<span>1 min ago</span><i>By Mike</i>
				<p>Lorem ipsum dolor sit amet, conse adipiscing. dolor sit amet, conse adip.</p>
				<div class="inbox-hover black">
					<a href="#" title="" data-tooltip="Read" data-placement="bottom"><i class="fa fa-eye"></i></a>
					<a href="#" title="" data-tooltip="Delete" data-placement="bottom"><i class="fa fa-trash-o"></i></a>
					<a href="#" title="" data-tooltip="Important" data-placement="bottom"><i class="fa fa-star-o"></i></a>
				</div>
			</li>
			<li><img src="http://placehold.it/50x50" alt="" />
				<span>1 min ago</span><i>By Mike</i>
				<p>Lorem ipsum dolor sit amet, conse adipiscing. dolor sit amet, conse adip.
ipsum dolor sit amet, conse adipiscing. dolor sit amet, conse adip.</p>
				<div class="inbox-hover black">
					<a href="#" title="" data-tooltip="Read" data-placement="bottom"><i class="fa fa-eye"></i></a>
					<a href="#" title="" data-tooltip="Delete" data-placement="bottom"><i class="fa fa-trash-o"></i></a>
					<a href="#" title="" data-tooltip="Important" data-placement="bottom"><i class="fa fa-star-o"></i></a>
				</div>
			</li>
			<li><img src="http://placehold.it/50x50" alt="" />
				<span>1 min ago</span><i>By Mike</i>
				<p>Lorem ipsum dolor sit amet, conse adipiscing. dolor sit amet, conse adip.Lorem ipsum dolor sit amet, conse adipiscing. dolor sit amet.</p>
				<div class="inbox-hover black">
					<a href="#" title="" data-tooltip="Read" data-placement="bottom"><i class="fa fa-eye"></i></a>
					<a href="#" title="" data-tooltip="Delete" data-placement="bottom"><i class="fa fa-trash-o"></i></a>
					<a href="#" title="" data-tooltip="Important" data-placement="bottom"><i class="fa fa-star-o"></i></a>
				</div>
			</li>
		</ul>
	</div>
</div><!-- INBOX Widget -->


<!-- RAIn ANIMATED ICON-->
<script>
  var icons = new Skycons();
  icons.set("rain", Skycons.RAIN);
  icons.play();
</script>

@stop