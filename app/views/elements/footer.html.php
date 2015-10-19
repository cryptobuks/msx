<footer class="container-fluid">
	<nav class="navbar navbar-bottom navbar-light bg-faded" >
		<div style="padding-left:20px;border-top:1px solid gray; border-bottom:1px dotted;background-color:#eeeeee">
			<ul class="nav navbar-nav container" >
				<li class="nav-item"><a class="nav-link" href="/">Home</a></li>		
				<li class="nav-item"><a class="nav-link" href="/company/contact">Contact</a></li>		
				<li class="nav-item"><a class="nav-link" href="/company/aboutus">About</a></li>	
				<li class="nav-item"><a class="nav-link" href="/company/howitworks">How it works</a></li>	
				<li class="nav-item"><a class="nav-link" href="/company/security">Security</a></li>	
				<li class="nav-item"><a class="nav-link" href="/company/riskmanagement">Risk</a></li>				
				<li class="nav-item"><a class="nav-link" href="/company/verification">Verification</a></li>						
				<li class="nav-item"><a class="nav-link" href="/company/privacy">Privacy</a></li>		
				<li class="nav-item"><a class="nav-link" href="/company/termsofservice">Terms</a></li>				
			</ul>
		</div>
				<div style="font-size:11px;border-top:1px solid gray;border-bottom:1px dotted " class="bg-success container-fluid">
		<p>© <?=COMPANY_START?> - <?=gmdate('Y',time())?> <?=COMPANY_NAME?> 
		<small><span class="pull-right"><?php 	echo number_format($pagetotaltime*1000,2);  ?> ms</span></small>
		</p>
		</div>

	</nav>
</footer>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', '', '');
  ga('send', 'pageview');
</script>