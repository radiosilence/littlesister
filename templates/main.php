<!DOCTYPE html>
<head>
  <?=($is_mobile ? '<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />' : null)?>
  <title><?=($title ? "{$title} &ndash; " :null)?>0xf.nl &raquo; Midijunkies gonna fuck you up.</title>
  <link rel="stylesheet" href="/css_lib/subverse.css" type="text/css"/> 
  <link rel="stylesheet" href="/css/main.css" type="text/css"/> 
  <script src="/js_lib/jquery.js" type="text/javascript"></script>
  <script src="/js_lib/jquery-lightbox.js" type="text/javascript"></script>
  <script src="/js_lib/jquery-ui.js" type="text/javascript"></script>
  <script src="/js_lib/common.js" type="text/javascript"></script>
  <link rel="canonical" href="http://trouble.0xf.nl/<?=$canonical?>" />
  <meta name="Description" content="<?=($title ? "{$title} &ndash; 0xf.nl" : '0xf.nl &ndash; Midijunkies gonna fuck you up.')?>">
</head>
<body>
<div class="container_12">
  
  <header class="grid_5"><h1>Little Sister Writes</h1></header>
  <div class="grid_8" id="content">  
    <article>
      <?=$content?>
    </article>
    <div id="disqus_thread"></div>
      <script type="text/javascript">
          var disqus_shortname = 'littlesister'; // required: replace example with your forum shortname

          // The following are highly recommended additional parameters. Remove the slashes in front to use.
          var disqus_identifier = '<?=$canonical?>';
          var disqus_url = 'http://littlesister.0xf.nl/<?=$canonical?>';

          (function() {
              var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
              dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
              (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
          })();
      </script>
      <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    <footer>
      <p><a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a></p>
    </footer>
  </div>
</div>
</body>
