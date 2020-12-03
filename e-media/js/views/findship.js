jQuery(function($) {
    //var obj = JSON.parse('{"ships":[{"mmsi":574201522,"name":"TAN TAI","type":0,"flag":"VNM"},{"mmsi":574667778,"name":"TAN TAI 1","type":0,"flag":"VNM"},{"mmsi":574667779,"name":"TAN TAI 2","type":0,"flag":"VNM"},{"mmsi":574244844,"name":"TAN TAI 2 A39","type":0,"flag":"VNM"},{"mmsi":574654548,"name":"TAN TAI 3","type":0,"flag":"VNM"},{"mmsi":574040018,"name":"TAN TAI 598 BD","type":60,"flag":"VNM"},{"mmsi":574003336,"name":"TAN TAI 6 A39","type":0,"flag":"VNM"},{"mmsi":574140619,"name":"TAN TAI D1","type":0,"flag":"VNM"},{"mmsi":533130632,"name":"TAN TAN","type":0,"flag":"MYS"},{"mmsi":574590261,"name":"TAN THANH E19","type":0,"flag":"VNM"}],"flag":"","ts":1492953495}');

    //console.log(obj.ships);

    function transformData(data){
      alert(data.ships);
    }

    $("#shipname").on('input', function() {
      $.ajax({
        url: "http://www.findship.co/v2_web/ship/search.php?",
        dataType: "JSON",
        type: 'GET',
        crossDomain: true,
        data: {
          text: $("#shipname").val()
        },
        success: function( data ) {
          //response( data.ships );
          alert(data.ships);
        }
      });
    });

    /*$( "#shipname" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
          url: "http://www.findship.co/v2_web/ship/search.php?callback=?",
          dataType: "jsonp",
          data: {
            text: request.term
          },
          success: function( data ) {
            //response( data.ships );
            alert(data.ships);
          }
        });
      },
      minLength: 3,
      select: function( event, ui ) {
        console.log(ui.ships);
      },
      open: function() {
        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });*/
  });
