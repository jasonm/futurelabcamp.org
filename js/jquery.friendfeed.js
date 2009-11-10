//<![CDATA[

/*
  name : friendfeed
  file : jquery.friendfeed.js
  author : gregory tomlinson
  ///////////////////////////
  ///////////////////////////    
  dependencies : jQuery 1.3.2
  ///////////////////////////
  ///////////////////////////
  
  The MIT License

  Copyright (c) 2009 Gregory Tomlinson
  
  http://www.opensource.org/licenses/mit-license.php  

*/

(function($) {

  $.fn.friendfeed = function( user, options ) {
  
    /* declare INSTANCE specific variables and settings */
    var defaults = {};
    /* extend the defaults to include all user specified options */
    $.extend( true, defaults, $.friendfeed.defaults, options );  
    
    defaults.user = user;     
    var  success = function( jo ) {
        if( !jo || !jo.entries ) { return false; }
        
        // provide 'this' as the target container        
        $.friendfeed.render( this, jo.entries, defaults );
      },    
      callback = $.friendfeed.delegate( success, this );
            
    /* connect to the remote data source: friendfeed */  
    $.friendfeed.connector( defaults.url+user, defaults.params, callback );
    
    return this; /* jQuery default behavior, return container */
  };

  $.friendfeed = {
  
    log : function( str ) {
      if( !this.defaults.debug ) { return; }
      try {
        console.log( str );
      } catch(e){}
    },
    connector : function( src, params, callback ) {
      var str = $.param(params);
      $.ajax({
        dataType: 'jsonp',
        data : str,
        jsonp: 'callback',
        url : src,
        success: callback
      });
    },
    render : function( container, items, defaults ) {
      var css = defaults.css, bx = $('<div />').addClass( css.bx );
      this.log( 'Render Elements' );
      for(var i=0; i<items.length; i++) {
        var d = $('<div />').addClass( css.item ).appendTo( bx ), subD = $('<div />').addClass( css.meta ).appendTo( d );
        $('<p />').html( items[i].body ).prependTo( d );
        
        if( items[i].from ) {
          $('<span />').html('from ').appendTo(subD);
          $('<a />').attr('href', "http://friendfeed.com" + items[i].from.id).html( items[i].from.name ).appendTo( subD ); 
        }
        // if( items[i].via ) { 
        //   $('<span />').html('via ').appendTo(subD);
        //   $('<a />').attr('href', items[i].via.url).html( items[i].via.name ).appendTo( subD ); 
        // }
      }
      bx.appendTo( container );
    },
    delegate : function( func, scope ) {
      // fix scope to point where I say it
      var fn = func;
      return function() {
        fn.apply( scope, arguments );
      }
    }
  }

  /* define defaults for override */
  $.friendfeed.defaults = {
    url : 'http://friendfeed-api.com/v2/feed/',
    user : '', debug : false,    
    params : {
      format : 'json',
      locale:'en',
      num : 10
    },
    css : {
      bx : 'ff_box',
      item : 'ff_item',
      meta : 'ff_meta'
    }
  };

})(jQuery);

//]]>
