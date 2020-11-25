<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0, minimal-ui">
<title><?php wp_title( '|', true, 'right' );bloginfo( 'name' );?></title>
<link href="https://fonts.googleapis.com/css?family=Noto+Serif+JP" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="all" href="/wp-content/themes/komiya/css/style.css">
<link rel="stylesheet" type="text/css" media="all" href="/wp-content/themes/komiya/css/hamburger.css">
<link rel="stylesheet" type="text/css" media="all" href="/wp-content/themes/komiya/css/accordion.css">

<link href="https://fonts.googleapis.com/css?family=Amiri|Frank+Ruhl+Libre|Halant|Libre+Baskerville|Lora|Lusitana|PT+Serif|Quattrocento|Scheherazade|Unna|Vollkorn" rel="stylesheet">

<?php wp_head(); ?>

<script type="text/javascript" src="/wp-content/themes/komiya/js/hamburger.js"></script>

<script type="text/javascript">
	// スマホアコーディオン
	jQuery(function(){
		jQuery(".accordionbox dt").on("click", function() {
			jQuery(this).next().slideToggle();
			// activeが存在する場合
			if (jQuery(this).children(".accordion_icon").hasClass('active')) {
				// activeを削除
				jQuery(this).children(".accordion_icon").removeClass('active');
			}
			else {
				// activeを追加
				jQuery(this).children(".accordion_icon").addClass('active');
			}
		});
	});
</script>
	<script type="text/javascript">

	var checkSelect = function () {
        var obj = event.target;

		jQuery('li.cat-item input[type="checkbox"]:checked').parent('label').css("background","#ddd");

		if ( !"parentElement" in obj || !"tagName" in obj.parentElement || 
			(event.target.parentElement.tagName != "LI" && event.target.parentElement.tagName != "LABEL") ) { return; }
		        
        if(obj.tagName == "LABEL") {
            if (obj.parentElement.classList[0] == "cat-item") {
                if (obj.style.background == "#fff" || obj.style.background.substr(0 ,18) == "rgb(255, 255, 255)" || obj.style.background == "") {
                    obj.style.background = "#ddd";
                } else {
                    obj.style.background = "#fff";
                }
            } 
        }
				
		var ofsize_collection = document.getElementsByName("ofsize");
		var ofsize_collection_length = ofsize_collection.length;
		for (var i = 0; i < ofsize_collection_length; i++) {
			sessionStorage.setItem('ofsize_selected'+i, ofsize_collection[i].selectedIndex);
		}
	    
		var ofprice_collection = document.getElementsByName("ofprice");
		var ofprice_collection_length = ofprice_collection.length;
		for (var i= 0; i < ofprice_collection_length; i++) {
			sessionStorage.setItem('ofprice_selected'+i, ofprice_collection[i].selectedIndex);
		}
		
		//checkAll();
	};
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAVbQSAh8wUsnOy6IHV-iLn062IOBEO6kA&callback=initMap" async defer></script>
<script src="/wp-content/themes/komiya/js/googlemap.js"></script>
<script>
  var map;
  function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: 35.686003, lng: 139.728286},
      zoom: 16
    });
  }
</script>
<?php if ( is_user_logged_in() ) {
	global $template;
	echo "このページで使用しているテンプレートファイル：" . basename($template);
} ?>