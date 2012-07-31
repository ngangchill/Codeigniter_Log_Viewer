<!DOCTYPE html>
<html>

<head>
<title>Log Viewer</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<link href="<?php echo site_url(uri_string().'?asset=css&file=style.css'); ?>" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="header_container">
	<div class="container">
        <div class="grid_6">
            <h1 id="logo"><a href="">Codeigniter Log Viewer</a></h1>
        </div>
        <div class="grid_6">
            <ul id="navigation">
            	<?php $level = $this->input->get('level'); ?>
            	<li class="<?php echo $level == NULL ? 'active' : ''; ?>">
                	<a href="<?php echo site_url(uri_string());?>">All</a>
               	</li>
                <li class="<?php echo $level == 'error' ? 'active' : ''; ?>">
                	<a href="<?php echo site_url(uri_string().'?level=error');?>">Error</a>
                </li>
                <li class="<?php echo $level == 'debug' ? 'active' : ''; ?>">
                	<a href="<?php echo site_url(uri_string().'?level=debug');?>">Debug</a>
                </li>
                <li class="<?php echo $level == 'info' ? 'active' : ''; ?>">
                	<a href="<?php echo site_url(uri_string().'?level=info');?>">Information</a>
                </li>
          	</ul>
        </div>
    </div>
</div>


<div id="body_container">
	<div class="container">
        <div class="grid_12">
            <div id="messages">
            	<?php foreach($messages as $message){ ?>
            	<div class="message <?php echo $message['level']; ?>">
                    <div class="left">
                        <a class="level"></a>
                        <span class="date"><?php echo $message['date']; ?></span>
                    </div>

                    <div class="right">
                        <p class="description"><?php echo $message['description']; ?></p>
                    </div>
                    <br class="clear"/>
                </div>
                <?php } ?>
          	</div>
        </div>
    </div>
</div>

<div id="footer_container">
	<div class="container">
        <div class="grid_12">
            <div id="copyright">
            	&copy; 2012 <strong><a href="http://uzaklab.com">Wahyu Kristianto</a></strong> | Codeigniter Log Viewer Library 
          	</div>
        </div>
    </div>
</div>


</body>
</html>