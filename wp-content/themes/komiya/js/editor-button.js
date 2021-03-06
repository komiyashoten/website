(function() {
    tinymce.create( 'tinymce.plugins.slider_shortcode_button', {
      init: function( ed, url ) {
        ed.addButton( 'slider', {
          title: 'スライダー',
          icon: 'code',
          cmd: 'slider'
        });
  
        ed.addCommand( 'slider', function() {
          var selected_text = ed.selection.getContent(),
              return_text = '[スライダー]' + selected_text + '[/スライダー]';
          ed.execCommand( 'mceInsertContent', 0, return_text );
        });
      },
      createControl : function( n, cm ) {
        return null;
      },
    });
    tinymce.PluginManager.add( 'slider_shortcode_button_plugin', tinymce.plugins.slider_shortcode_button );

    tinymce.create( 'tinymce.plugins.inPageLink_shortcode_button', {
      init: function( ed, url ) {
        ed.addButton( 'inPageLink', {
          title: 'ページ内リンク',
          icon: 'code',
          cmd: 'inPageLink'
        });
  
        ed.addCommand( 'inPageLink', function() {
          var selected_text = ed.selection.getContent(),
              return_text = '[ページ内リンク]' + selected_text + '[/ページ内リンク]';
          ed.execCommand( 'mceInsertContent', 0, return_text );
        });
      },
      createControl : function( n, cm ) {
        return null;
      },
    });
  tinymce.PluginManager.add( 'inPageLink_shortcode_button_plugin', tinymce.plugins.inPageLink_shortcode_button );

  tinymce.create( 'tinymce.plugins.product_shortcode_button', {
    init: function( ed, url ) {
      ed.addButton( 'product', {
        title: '商品',
        icon: 'code',
        cmd: 'product'
      });

      ed.addCommand( 'product', function() {
        var selected_text = ed.selection.getContent(),
            return_text = '[商品 id=""]';
        ed.execCommand( 'mceInsertContent', 0, return_text );
      });
    },
    createControl : function( n, cm ) {
      return null;
    },
  });
tinymce.PluginManager.add( 'product_shortcode_button_plugin', tinymce.plugins.product_shortcode_button );

tinymce.create( 'tinymce.plugins.products_shortcode_button', {
  init: function( ed, url ) {
    ed.addButton( 'products', {
      title: '複数商品',
      icon: 'code',
      cmd: 'products'
    });

    ed.addCommand( 'products', function() {
      var selected_text = ed.selection.getContent(),
          return_text = '[複数商品]' + selected_text + '[/複数商品]';
      ed.execCommand( 'mceInsertContent', 0, return_text );
    });
  },
  createControl : function( n, cm ) {
    return null;
  },
});
tinymce.PluginManager.add( 'products_shortcode_button_plugin', tinymce.plugins.products_shortcode_button );

})();