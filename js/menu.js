jQuery(document).ready(function($){
  $(".lnkComida").click(function(event){
  	event.preventDefault();
	var seleccionado = $(this).attr("data-select");
	$("#mnuMainComida li.selected").appendTo("#mnuMainComida");
	$("#mnuMainComida li").removeClass('selected');
	itemComida = $(".lnkComida[data-select="+seleccionado+"]").parent("li");
	//itemComida.hide();
	itemComida.addClass("selected");
    $(".mnuComida").not("#mnuBebidas").hide();
    $("#mnu"+ seleccionado).show();
   itemComida.prependTo("#mnuMainComida");
  });
  $("a.lnkComida[data-select=Pozole]").click();
  
});