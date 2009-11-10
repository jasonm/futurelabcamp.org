<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <?php
    require_once('php/simplepie.inc');

    $twitter_feed = new SimplePie();
    $twitter_feed->set_feed_url('http://search.twitter.com/search.atom?q=%23futurelabcamp');
    $twitter_feed->enable_cache(false);
    $twitter_feed->init();
    $twitter_feed->handle_content_type();


    require_once("php/friendfeed.php");
    require_once("php/JSON.php");

    $friendfeed = new FriendFeed();
    $friendfeed_results = $friendfeed->search("futurelabcamp", null, 0, 100);
 
    //Sample PHP code to get data for a specific users feed via the FriendFeed API
    //The below gets the first 30 entries in that users feed
    // $feed = $friendfeed->fetch_user_feed("some_random_user_name", 0, 0, 30);
    foreach ($friendfeed_results->entries as $entry) {
      $output .= '<li class="tweet">';
      $output .= '<img src="' . $entry->service->iconUrl . '" alt="' . $entry->service->name . '" />';
      $output .= '<a href="'.$entry->link.'">'.$entry->title.'</a>';
      $output .= date(' Y/m/d', $entry->published);
      $output .= '</li>';
    }
  ?>

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="description" name="description" content="FutureLabCamp: An unconference in Boston focused on the future of scientific laboratories." />
    <meta http-equiv="keywords" name="keywords" content="beer, laser" />
    <title>FutureLabCamp</title>
    <link rel="stylesheet" href="css/blueprint/screen.css" type="text/css" media="screen, projection" />
    <link rel="stylesheet" href="css/blueprint/src/typography.css" type="text/css" media="screen, projection" />
    <link rel="stylesheet" href="css/blueprint/print.css" type="text/css" media="print" />
    <link rel="stylesheet" href="css/site.css" type="text/css" media="screen, projection" />
    <!--[if lt IE 8]>
      <link rel="stylesheet" href="css/blueprint/ie.css" type="text/css" media="screen, projection" />
    <![endif]-->
  </head>
  <body class="homepage xshowgrid">
    <div class="container">

      <div class="span-24 last prepend-top">
        <div class="span-18"><h1><span>FutureLabCamp</span></h1></div>
        <div class="date span-6 last"><h2>Boston 2010</h2></div>
      </div>

      <h2 class="prepend-3 span-18 last append-bottom">
        <span><em>How do open source hardware and software, cloud computing, low-cost and DIY instruments, and the internet of things converge to build the future of scientific labs?</span></em>
      </h2>
      <div class="span-12">
        <div class="span-12 last">
          <h3>The Event</h3>
          Come to discuss and build the answers. FutureLabCamp, just like BarCamp, is an ad-hoc gathering born from the desire for people to share and learn in an open environment. It is an intense event with discussions, demos and interaction from participants who are the main actors of the event.
        </div>
        <div class="span-12 last">
          <h3>Comments</h3>
          <div id="disqus_thread"></div><script type="text/javascript" src="http://disqus.com/forums/futurelabcamp/embed.js"></script><noscript><a href="http://disqus.com/forums/futurelabcamp/?url=ref">View the discussion thread.</a></noscript><a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>
        </div>
      </div>
      <div class="span-6">
        <h3>References</h3>
        <ul class="twitter-results">
        <?php echo $output; //prints the entry title, icon and link to the entry ?>
        </ul>
      </div>  
      <div class="span-6 last">
        <h3>Twitter</h3>
        <p>Follow <a href="http://twitter.com/futurelabcamp">@futurelabcamp</a> on Twitter.</p>

        <ul class="twitter-results">
          <?php foreach ($twitter_feed->get_items() as $item): ?>
            <li class="tweet">
              <?php echo $item->get_description(); ?><br/>
              <a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_date('F j, Y g:i a'); ?></a>
            </li>
          <?php endforeach; ?>
        </ul>

      </div>  
      <div class="footer span-24 last">
        Contact <a href="http://twitter.com/jayunit">Jason Morrison</a> (<a href="mailto:jason.p.morrison@gmail.com">email</a>) with any questions or comments.<br/>
        This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/us/">Creative Commons Attribution-Share Alike 3.0 United States License</a>.
      </div>
    </div>

    <!-- Jabascripts -->
    <script type="text/javascript">
      //<![CDATA[
      (function() {
        var links = document.getElementsByTagName('a');
        var query = '?';
        for(var i = 0; i < links.length; i++) {
        if(links[i].href.indexOf('#disqus_thread') >= 0) {
          query += 'url' + i + '=' + encodeURIComponent(links[i].href) + '&';
        }
        }
        document.write('<script charset="utf-8" type="text/javascript" src="http://disqus.com/forums/futurelabcamp/get_num_replies.js' + query + '"></' + 'script>');
      })();
      //]]>
    </script>

    <script type="text/javascript">
      //<![CDATA[
      var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
      document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
      //]]>
    </script>
    <script type="text/javascript">
      //<![CDATA[
      try {
        var pageTracker = _gat._getTracker("UA-11453223-1");
        pageTracker._trackPageview();
        } catch(err) {}
      //]]>
    </script> 
  </body>
</html>
