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
				if ('<?php global $template; echo basename($template); ?>' == 'taxonomy.php') {
					checkAll();
				} else {
					jQuery('input[type="submit"]').prop("disabled", true);
					jQuery('input[type="submit"]').css('background','#f8f8f8');
				}
			}
		});
	});
</script>
<script type="text/javascript">
	var checkAll = function () {
		
        var activeFlag = 0;
            
        //全てのチェックボックスのどれかが選択されている？
        if(jQuery("input[type=checkbox]:checked").size() > 0) {
            activeFlag = 1;
        }
    
        //セレクトボックスの初期値以外が選択されている？
        var ofsize_collection = document.getElementsByName("ofsize");
        var ofsize_collection_length = ofsize_collection.length;
        for (var i=0; i < ofsize_collection_length; i++ ) {
            if(ofsize_collection[i].selectedIndex != 0) {
                activeFlag = 1;
            }
        }
        var ofprice_collection = document.getElementsByName("ofprice");
        var ofprice_collection_length = ofprice_collection.length;
        for (var i=0; i < ofprice_collection_length; i++ ) {
            if(ofprice_collection[i].selectedIndex != 0) {
                activeFlag = 1;
            }
        }
        
        if (activeFlag == 1) {
            jQuery('input[type="submit"]').prop("disabled", false);
            //jQuery('input[type="submit"]').removeAttr('disabled');
            jQuery('input[type="submit"]').css('background','');
        } else {
            jQuery('input[type="submit"]').prop("disabled", true);
            jQuery('input[type="submit"]').css('background','#f8f8f8');
        }
	};
</script>
<script type="text/javascript">

	var checkSelect = function () {
        var obj = event.target;
        if ( !"parentElement" in obj || !"tagName" in obj.parentElement || 
			(event.target.parentElement.tagName != "LI" && event.target.parentElement.tagName != "LABEL" || event.target.tagName == "DIV" || event.target.tagName == "P") ) { return; }
		
        jQuery('li.cat-item input[type="checkbox"]:checked').parent('label').css("background","#ddd");
        
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
			sessionStorage.setItem('ofsize'+i, ofsize_collection[i].value);
		}
	    
		var ofprice_collection = document.getElementsByName("ofprice");
		var ofprice_collection_length = ofprice_collection.length;
		for (var i= 0; i < ofprice_collection_length; i++) {
			sessionStorage.setItem('ofprice'+i, ofprice_collection[i].value);
		}
		
		checkAll();
	};
</script>
<script>
	window.onpageshow = function(event) {
    	if (event.persisted || window.performance && 
            window.performance.navigation.type == 2) {
 		  	//alert("backed");
			jQuery('li.cat-item input[type="checkbox"]:checked').parent('label').css("background","#ddd");
			//jQuery('select option').removeAttr("selected");
			
			var ofsizee_collection = document.getElementsByName("ofsize");
			var ofsize_collection_length = ofsize_collection.length;
			for (var i = 0; i < ofsize_collection_length; i++) {
				jQuery('select option[value='+sessionStorge.getItem("ofsize"+i)+']').attr("selected", "selected");
			}
			var ofprice_collection = document.getElementsByName("ofprice");
			var ofprice_collection_length = ofprice_collection.length;
			for (var i = 0; i < ofprice_collection_length; i++) {
				jQuery('select option[value='+sessionStorge.getItem("ofprice"+i)+']').attr("selected", "selected");
			}
		}
		
		if ('<?php global $template; echo basename($template); ?>' == 'taxonomy.php') {
			checkAll();
		}	
	};
</script>

<!--<script src="https://maps.google.com/maps/api/js?key=AIzaSyAVbQSAh8wUsnOy6IHV-iLn062IOBEO6kA"></script>-->

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