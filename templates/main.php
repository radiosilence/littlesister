<!DOCTYPE html>
<head>
  <?=($is_mobile ? '<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />' : null)?>
  <title><?=($title ? "{$title} &ndash; " :null)?>Little Sister Writes.</title>
  <link rel="stylesheet" href="/css_lib/subverse.css" type="text/css"/> 
  <link rel="stylesheet" href="/css/main.css" type="text/css"/> 
  <script src="/js_lib/jquery.js" type="text/javascript"></script>
  <script src="/js_lib/jquery-lightbox.js" type="text/javascript"></script>
  <script src="/js_lib/jquery-ui.js" type="text/javascript"></script>
  <script src="/js_lib/jquery-markitup.js" type="text/javascript"></script>
  <script src="/js_lib/markitup/sets/markdown/set.js" type="text/javascript"></script>
  <script src="/js_lib/common.js" type="text/javascript"></script>
  <link rel="canonical" href="http://littlesister.0xf.nl/<?=$canonical?>" />
  <meta name="Description" content="<?=($title ? "{$title} &ndash; Little Sister Writes" : 'Little Sister Writes.')?>">
</head>
<body>
<div class="container_12">
  <header class="grid_12"><h1><a href="/">Little Sister Writes</a></h1></header>
  <div class="grid_8" id="content">  
      <?=$content?>
  </div>
  <div class="grid_2" id="tags">
    <h1>Tags</h1>
    <p>
    <ul>
      <li><a href="#">Tag 1</a></li>
      <li><a href="#">Tag 2</a></li>
      <li><a href="#">Tag 3</a></li>
      <li><a href="#">Tag 4</a></li>
      <li><a href="#">Tag 5</a></li>
      <li><a href="#">Tag 6</a></li>
    </ul>
    </p><p>
  <a href="/admin">Admin</a></p>
  </div>

    <?php if($canonical): ?>
    <div id="disqus_thread" class="grid_8"></div>
      <script type="text/javascript">
          var disqus_shortname = 'littlesister'; // required: replace example with your forum shortname

          // The following are highly recommended additional parameters. Remove the slashes in front to use.
          var disqus_identifier = '/<?=$canonical?>';
          var disqus_url = 'http://littlesister.0xf.nl/<?=$canonical?>';

          (function() {
              var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
              dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
              (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
          })();
      </script>
      <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    <footer class="grid_8">
      <p><a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a></p>
    </footer>
    <?php endif;?>
</div>
</body>
