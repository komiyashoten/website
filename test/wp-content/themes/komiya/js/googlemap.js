// JavaScript Document

function initialize() {
  var latlng = new google.maps.LatLng(35.691994,139.783906);/*表示したい場所の経度、緯度*/
  var myOptions = {
	zoom: 16, /*拡大比率*/
	center: latlng, /*表示枠内の中心点*/
	mapTypeControlOptions: { mapTypeIds: ['noText', google.maps.MapTypeId.ROADMAP] }/*表示タイプの指定*/
  };
  var map = new google.maps.Map(document.getElementById('map_custmomize'), myOptions);/*マップのID取得*/

  /*スタイルのカスタマイズ*/
  var styleOptions =
[
    {
        "featureType": "administrative",
        "elementType": "all",
        "stylers": [
            {
                "saturation": "-100"
            }
        ]
    },
    {
        "featureType": "administrative.province",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 65
            },
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": "50"
            },
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "saturation": "-100"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "all",
        "stylers": [
            {
                "lightness": "30"
            }
        ]
    },
    {
        "featureType": "road.local",
        "elementType": "all",
        "stylers": [
            {
                "lightness": "40"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "geometry",
        "stylers": [
            {
                "hue": "#ffff00"
            },
            {
                "lightness": -25
            },
            {
                "saturation": -97
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "labels",
        "stylers": [
            {
                "lightness": -25
            },
            {
                "saturation": -100
            }
        ]
    }
];

 var styledMapOptions = { name: '小宮商店' }
  var sampleType = new google.maps.StyledMapType(styleOptions, styledMapOptions);
  map.mapTypes.set('sample', sampleType);
  map.setMapTypeId('sample');

/*WEB企画アイコンの取得*/
var icon = new google.maps.MarkerImage('/wp-content/themes/komiya/img/map-icon.png',/*アイコンの場所*/
  new google.maps.Size(104,46),/*アイコンのサイズ*/
  new google.maps.Point(0,0)/*アイコンの位置*/
);

/*マーカーの設置*/
var markerOptions = {
  position: latlng,/*表示場所と同じ位置に設置*/
  map: map,
  icon: icon,
  title: '小宮商店'/*マーカーのtitle*/
};
var marker = new google.maps.Marker(markerOptions);

}