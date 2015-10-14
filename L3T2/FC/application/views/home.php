	
   <style>
  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      width: 100%;
      padding: 0%;
      margin: auto;
  }

  html, body {
  height: 100%;
}

#wrap {
  min-height: 85%;
}

#myCarousal {
  overflow:auto;
  padding-bottom:150px; /* this needs to be bigger than footer height*/
}

.footer {
  position: relative;
  margin-top: -80px; /* negative value of footer height */
  height: 100px;
  clear:both;
  padding-top:20px;
} 
{
	background-color: orange;
}
.footer ul{
	margin-top: 2%;
}
.footer ul li a{color: yellow;}
.footer ul li a:hover{color: blue;}
.footer ul li a:focus{color: magenta;}
.footer ul li a:active{color: orange;}

  </style>
  </head> 
  <body>

<div id = "wrap">
<div class="container">
  <br>
  
  <?php
	if($login_error==true)
	{	
		echo '<div class="alert alert-danger">
				<strong><span class="glyphicon glyphicon-remove"></span> Login Failed! Username and password didn\'t match </strong>
			 </div>';
	}
	if($registration_success==true)
	{	
		echo '<div class="alert alert-success">
				<strong><span class="glyphicon glyphicon-ok"></span> Registration Completed. </strong>
			 </div>';
	}
  ?>
		
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="<?php echo base_url('images/b1.png'); ?>" alt="Tigers">
      </div>

      <div class="item">
        <img src="<?php echo base_url('images/b2.png'); ?>" alt="Bangladesh Cricket">
      </div>
    
      <div class="item">
        <img src="<?php echo base_url('images/b3.png'); ?>" alt="The Boss">
      </div>

      <div class="item">
        <img src="<?php echo base_url('images/b4.png'); ?>" alt="Winners!">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

<!--<footer>
<div class="panel panel-default" class="navbar navbar-inverse" style="height:">
    <div class="panel-body">
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-left">
                <li><a>About Us</a></li>
                <li><a>Services Provided</a></li>
                <li><a>Contact Us</a></li>
                <!--
				<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Portfolio <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">1 Column Portfolio</a></li>
                        <li><a href="#">2 Column Portfolio</a></li>
                        <li><a href="#">Single Portfolio Item</a></li>
                    </ul>
                </li>
				
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Blog <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Blog Section</a></li>
                        <li><a href="#">Blog Section</a></li>
                        <li><a href="#">Blog Section</a></li>
                    </ul>
                </li>
	
	</ul>
        </div>
    </div>
</div>
</footer>
-->

</div>

<footer class="footer">
	<ul class="nav navbar-nav navbar-left">
                <li><a href="#">About Us</a></li>
                <li><a href="#">Services Provided</a></li>
                <li><a href="#">Contact Us</a></li>
	</ul>
    
</footer>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.11.2.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>

</body>

</html>