$(function(){

  $('#buttonsubmit').click(function(e){
    e.preventDefault();
    var unitModem = $('#unit_modem').val();
    if(unitModem > 1){
      var rsltObj = checkMultipleSelect();
      if (rsltObj.unselected) {
        alert("Please select for modem " + rsltObj.unselected);
      } else if (rsltObj.selectedTwice) {
        alert("Modem " + rsltObj.selectedTwice + " has been selected twice");
      } else{
        $('#f').submit();
      }
    }else{
      if($("#assembly_id").prop('selectedIndex') == 0){
        alert("Please select available modem");
      } else{
        $('#f').submit();
      }
    }
  });

  function checkMultipleSelect(){
    var valsTaken = [];
    var unitModem = $('#unit_modem').val();
    for (var i = 1; i <= unitModem; i++) {
      var idx = $("#assembly_id"+i).prop('selectedIndex');
      if (idx == 0) return { unselected: i };
      if (valsTaken[idx]) return {  selectedTwice: idx };
      valsTaken[idx] = true;
    }
    return {ok: true};
  }
});
