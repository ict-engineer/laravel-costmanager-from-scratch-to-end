// Main JS Document


// First
var getUrl = window.location;
var baseurl = getUrl .protocol + "//" + getUrl.host + '/custom_components/function_table/img/';
const themes = ["Blue", "Purple", "Red", "Green", "Orange"];


// Fun
function newId() {
  var numItems = $('.dropdown-trigger').length;
  return numItems + 1;
}
function newMId() {
  var numItems = $('.material-field').length;
  return numItems + 1;
}
function z(x) {
  var parts=x.toString().split(".");
  return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + (parts[1] ? "." + parts[1] : "");
}

function z1(x, symbol) {
  var parts=x.toString().split(".");
  return symbol + parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + (parts[1] ? "." + parts[1] : "");
}


// Adding Groups
$("body").on("click",".addNewGroup",function(){
	addGroup();
});


// Adding Groups
$("body").on("click",".addService",function(){
    
    addService();
});

$("body").on("click",".addEmployee",function(){
    addEmployee();
});


// Insert At Position
jQuery.fn.insertAt = function(index, element) {
    var lastIndex = this.children().length;
    if (index < 0)
        index = Math.max(0, lastIndex + 1 + index);
    this.append(element);
    if (index < lastIndex)
        this.children().eq(index).before(this.children().last());
    return this;
}



$('body').on('click', ".ftNewBtn", function() {
    addNew($(this).parent().parent());
});
$('body').on('keypress', ".ftNew > td > .invisInput" ,function(e) {
    if(e.which == 13)
    {
        e.preventDefault();
        addNew($(this).parent().parent());
    }
});
$('body').on('keypress', ".ftNew > td > .input-field > .invisInput" ,function(e) {
    if(e.which == 13)
    {
        e.preventDefault();
        addNew($(this).parent().parent().parent());
    }
});
// TR New Other Cells
$('body').on('click', ".ftNew td:nth-child(4), .ftNew td:nth-child(5), .ftNew td:nth-child(6)", function() {
    
    var id = $(this).parent().parent().parent().parent().parent().attr('id');
    if(id == 'fGroups')
        $(this).parent().children(':nth-child(3)').children(':first').focus();
    else
        $(this).parent().children(':nth-child(3)').children(':first').children(':first').focus();
});

function setDropdown(element){
  var id = element.attr('id');
  $('#'+id).dropdown();
}

// Dragging Items
function setDraggable() {
    $(function() {
        var c = {}, tableCount = 0, cloner = null, si = null, siCloner = null;
        $(".fGroup > .ftGroup > tbody > tr:not(.ftNew):not(.ftSubitems)").draggable({
            helper: "clone",
            start: function(event, ui) {
                c.tr = this;
                c.helper = ui.helper;
                $(this).fadeOut(92);
                tableCount = $(this).parent().children().length;
                cloner = $(this).clone();
                cloner.css({opacity:1});
                si = $(this).parent().children().eq($(this).parent().children().index($(this)) + 1);
                siCloner = si.clone();
                si.fadeOut(92);
            },
            drag: function(event, ui) {
                var mNum = [ui.offset.left, ui.offset.top, $(this).width(), $(this).height()],
                    tBody = $(this).parent(), table = tBody.parent(),
                    tNum = [table.offset().left, table.offset().top, table.width(), table.height()],
                    rowSize = $(this).height(),
                sis = tBody.children().eq(tBody.children().index($(this)) + 1),
                sisSize = sis.height();
              if (sis.css("display") == "none") sisSize = 0;
                  if (((mNum[1] + mNum[3] + sisSize) > tNum[1] || mNum[1] < (tNum[1] + tNum[3] + sisSize)) && 
                      ((mNum[0] + mNum[2]) > tNum[0] || mNum[0] < (tNum[0] + tNum[2]))) {

                    var res = 0, ongoing = rowSize, dist = mNum[1] - tNum[1];// + (mNum[3] / 2) + (sisSize / 2)
                    if (dist > ongoing) for (v = 0; v < tBody.children().length; v++) {
                      if (tBody.children().eq(v).css("display") != "none")
                        ongoing += tBody.children().eq(v).height();
                      res += 1;
                      if (ongoing > dist && tBody.children().eq(v).hasClass("ftSubitems")) break;
                  }
                    if (res < 0) res = 0;
                    if (res > tableCount - 2) res = tableCount - 2;
                    if (!tBody.children().eq(res).hasClass("ftIDroppable")) {
                        $(".ftIDroppable").remove();
                        tBody.insertAt(res, '<tr class="ftIDroppable"><td colspan="7"><div></div></td></tr>');
						//var dashed = tBody.children().eq(res).children().first().children().first();
                    }
                }
            },
            stop: function(event, ui) {
                $(".ftIDroppable").remove();
                    var mNum = [ui.offset.left, ui.offset.top, $(this).width(), $(this).height()],
                        that = $(this),
                        tBody = $(this).parent(), table = tBody.parent(),
                        tNum = [table.offset().left, table.offset().top, table.width(), table.height()],
                        rowSize = $(this).height(),
                sis = tBody.children().eq(tBody.children().index($(this)) + 1),
                sisSize = sis.height();
                if (sis.css("display") == "none") sisSize = 0;
                if (((mNum[1] + mNum[3] + sisSize) > tNum[1] || mNum[1] < (tNum[1] + tNum[3] + sisSize)) && 
                    ((mNum[0] + mNum[2]) > tNum[0] || mNum[0] < (tNum[0] + tNum[2]))) {
                    mNum = [ui.offset.left, ui.offset.top, $(this).width(), $(this).height()];
                              tNum = [table.offset().left, table.offset().top, table.width(), table.height()];
                    $(this).remove();
                    si.remove();
                    var res = 0, ongoing = rowSize, dist = mNum[1] - tNum[1];// + (mNum[3] / 2) + (sisSize / 2)
                    if (dist > ongoing) for (v = 0; v < tBody.children().length; v++) {
                      if (tBody.children().eq(v).css("display") != "none")
                        ongoing += tBody.children().eq(v).height();
                      res += 1;
                      if (ongoing > dist && tBody.children().eq(v).hasClass("ftSubitems")) break;
                    }
                              if (res < 0) res = 0;
                    if (res > tableCount - 4) res = tableCount - 4;
                    tBody.insertAt(res, cloner);
                    tBody.insertAt(res + 1, siCloner);
                  setDraggable();
                } else $(this).fadeIn(92);
                
                setDropdown($(this).children(":first").children(":first"));
                
                var subtbody = sis.children(':first').children(':first').children(':first').children(':nth-child(2)');
                for(var i = 0; i < subtbody.length; i ++)
                {
                    setDropdown(subtbody.children().eq(i).children(":first").children(":first"));
                }
            }
        });
		
		var cSI = {}, tableCountSI = 0, clonerSI = null;
        $(".ftSITable > tbody > tr:not(.ftNewSI)").draggable({
            helper: "clone",
            start: function(event, ui) {
                cSI.tr = this;
                cSI.helper = ui.helper;
                $(this).fadeOut(92);
                tableCountSI = $(this).parent().children().length;
                clonerSI = $(this).clone();
                clonerSI.css({opacity:1});
            },
            drag: function(event, ui) {
                var mNum = [ui.offset.left, ui.offset.top, $(this).width(), $(this).height()],
                    tBody = $(this).parent(), table = tBody.parent(),
                    tNum = [table.offset().left, table.offset().top, table.width(), table.height()],
                    rowSize = tBody.children().first().height();
                if (((mNum[1] + mNum[3]) > tNum[1] || mNum[1] < (tNum[1] + tNum[3])) && 
                    ((mNum[0] + mNum[2]) > tNum[0] || mNum[0] < (tNum[0] + tNum[2]))) {

                    var res = Math.floor(((mNum[1] + (mNum[3] / 2)) - tNum[1]) / rowSize) - 1;
                    if (res < 0) res = 0;
                    if (res > tableCountSI - 2) res = tableCountSI - 2;
                    if (!tBody.children().eq(res).hasClass("ftIDroppable")) {
                        $(".ftIDroppable").remove();
                        tBody.insertAt(res, '<tr class="ftIDroppable"><td colspan="7"><div></div></td></tr>');
                    }
                }
            },
            stop: function(event, ui) {
              
				        $(".ftIDroppable").remove();
                var mNum = [ui.offset.left, ui.offset.top, $(this).width(), $(this).height()],
                    tBody = $(this).parent(), table = tBody.parent(),
                    tNum = [table.offset().left, table.offset().top, table.width(), table.height()],
                    rowSize = tBody.children().first().height();
                if (((mNum[1] + mNum[3]) > tNum[1] || mNum[1] < (tNum[1] + tNum[3])) && 
                    ((mNum[0] + mNum[2]) > tNum[0] || mNum[0] < (tNum[0] + tNum[2]))) {
				          	mNum = [ui.offset.left, ui.offset.top, $(this).width(), $(this).height()];
                    tNum = [table.offset().left, table.offset().top, table.width(), table.height()];
					          $(this).remove();
                    var res = Math.floor(((mNum[1] + (mNum[3] / 2)) - tNum[1]) / rowSize) - 1;
                    if (res < 0) res = 0;
                    if (res > tableCountSI - 3) res = tableCountSI - 3;
                    tBody.insertAt(res, clonerSI);
                    setDraggable();
                } else $(this).fadeIn(92);
                setDropdown($(this).children(":first").children(":first"));

            }
        });
    });
}
setDraggable();



function checkSITotal(tBody, symbol) {
	var sum = 0, pSum = tBody.parent().parent().parent().parent().prev().children().eq(4).children().first();
    for (s = 0; s < tBody.children().length; s++)
    {
      var text = tBody.children().eq(s).children().eq(5).children().first().val();
      if(text.substring(0, 1) >= '0' && text.substring(0, 1) <= '9')
      {
        tBody.children().eq(s).children().eq(5).children().first().val(symbol + text);
      }
      text = text.substring(1, text.length);
        sum += Number.parseFloat(text.replaceAll(",", ""));
    }
    pSum.val(z1(sum, symbol)).change();
}
function checkSITotalSmall(bigTBody, symbol) {
	var pSum = bigTBody.parent().parent().parent().parent().prev().children().eq(2).children().last()
            .children().first().children().last().children().eq(3).children().last().children().first(), sum = 0;
    for (s = 0; s < bigTBody.children().length; s++)
        sum += Number.parseFloat(bigTBody.children().eq(s).children().first().children().first()
            .children().last().children().last().children().eq(4).children().last().children().first().val()
								 .replaceAll(",", ""));
    pSum.val(z1(sum, symbol));
}
function f(th) { th.val(z(th.val().replaceAll(",", ""))); }
	$('body').on('click', ".ftDelete", function() {
		if ($(this).parent().parent().parent().hasClass("ftGSelector")) {
            $(this).parent().parent().parent().parent().parent().parent().parent().remove();
		} else {
			var TR = $(this).parent().parent().parent().parent(),
				tBody = TR.parent(),
				sis = tBody.children().eq(tBody.children().index(TR) + 1) ;
			TR.remove();
			sis.remove();
		}
	});
	
    $('body').on('click', ".ftMDelete", function() {
        var tBody = $(this).parent().parent().parent().parent().parent();
        $(this).parent().parent().parent().parent().remove();
        if(tBody.children().length == 0)
        {
           var costInput = tBody.parent().parent().parent().parent().parent().children().eq(tBody.parent().parent().parent().parent().parent().children().index(tBody.parent().parent().parent().parent()) - 1).children(':nth-child(5)').children(':first');
           costInput.prop( "readonly", false);
           var expandLi = tBody.parent().parent().parent().parent().parent().children().eq(tBody.parent().parent().parent().parent().parent().children().index(tBody.parent().parent().parent().parent()) - 1).children(':first').children(':nth-child(2)').children(':first');
           expandLi.hide();
           sis = tBody.parent().parent().parent().parent(),
                sis.fadeToggle(200, function() {
            });
        }
	});
	$('body').on('click', "a.fttBlue", function() {
        var div = $(this).parent().parent().parent().parent().parent().parent().parent();
        for (v = 0; v < themes.length; v++) div.removeClass("ftt" + themes[v]);
        div.addClass("fttBlue");
    });
	$('body').on('click', "a.fttPurple", function() {
        var div = $(this).parent().parent().parent().parent().parent().parent().parent();
        for (v = 0; v < themes.length; v++) div.removeClass("ftt" + themes[v]);
        div.addClass("fttPurple");
    });
	$('body').on('click', "a.fttRed", function() {
        var div = $(this).parent().parent().parent().parent().parent().parent().parent();
        for (v = 0; v < themes.length; v++) div.removeClass("ftt" + themes[v]);
        div.addClass("fttRed");
    });
	$('body').on('click', "a.fttGreen", function() {
        var div = $(this).parent().parent().parent().parent().parent().parent().parent();
        for (v = 0; v < themes.length; v++) div.removeClass("ftt" + themes[v]);
        div.addClass("fttGreen");
    });
	$('body').on('click', "a.fttOrange", function() {
        var div = $(this).parent().parent().parent().parent().parent().parent().parent();
        for (v = 0; v < themes.length; v++) div.removeClass("ftt" + themes[v]);
        div.addClass("fttOrange");
    });
	
	$('body').on('click', ".ftDeleteSI", function() {
        if (!$(this).parent().hasClass("ftSISmall"))
        {
            var tBody = $(this).parent().parent().parent();
             $(this).parent().parent().remove();
             if(tBody.children().length == 0)
             {
                var costInput = tBody.parent().parent().parent().parent().parent().children().eq(tBody.parent().parent().parent().parent().parent().children().index(tBody.parent().parent().parent().parent()) - 1).children(':nth-child(5)').children(':first');
                costInput.prop( "readonly", false);
                var expandLi = tBody.parent().parent().parent().parent().parent().children().eq(tBody.parent().parent().parent().parent().parent().children().index(tBody.parent().parent().parent().parent()) - 1).children(':first').children(':nth-child(2)').children(':first');
                expandLi.hide();
                sis = tBody.parent().parent().parent().parent(),
                sis.fadeToggle(200, function() {
                });
             }
        }
        else
        {
             $(this).parent().parent().parent().remove();
        }
	});
	// $('body').on('click', ".ftAddSI", function() {
	// 	addNewSubitem($(this).parent().parent(), true);
	// });
	// $(".ftNewSI > td > .invisInput").on('keypress',function(e) {
    //     if(e.which == 13)
    //     {
    //       e.preventDefault();
    //        addNewSubitem($(this).parent().parent(), true);
    //     }
    // });
    $('body').on('click', ".ftAddSIRemote", function() {
		addNewSubitem($(this).parent().parent().parent().parent().next()
					  .children().first().children().first().children().first()
					  .children().last(), false, $(this).parent().parent().parent().parent().next()
					  .children().first().children().first().children().first()
					  .children().last().children().length);
	});
	$('body').on('click', ".ftMAddSIRemote", function() {
        trTmp = $(this).parent().parent().parent().parent();
		addNewSubitem(trTmp.parent(), false, trTmp.parent().children().index(trTmp) + 1);
	});
	
	$('body').on('click', ".ftOFIcon", function() {
		var overflow = $(this).parent().children().last();
		if (overflow.css("display") == "none") {
			overflow.slideDown(123);
			$(this).attr("src", baseurl + "fav_negative.svg");
		} else {
			overflow.slideUp(123);
			$(this).attr("src", baseurl + "fav_positive.svg");
		}
	});
	$('body').on('click', ".ftSIOFIcon", function() {
		var TR = $(this).parent().parent(), tbody = TR.parent(),
			toggleList = [
				tbody.children().eq(1),
				tbody.children().eq(2),
				tbody.children().eq(3),
				tbody.children().eq(4)
			],
			b = toggleList[0].css("display") == "none";
		for (t = 0; t < toggleList.length; t++) {
			if (b) toggleList[t].slideDown(123);
            else toggleList[t].slideUp(123);
		}
		if (b) {
			$(this).attr("src", baseurl + "fav_negative.svg");
			TR.addClass("ftSIOFExpanded");
		} else {
			$(this).attr("src", baseurl + "fav_positive.svg");
			TR.removeClass("ftSIOFExpanded");
		}
    });

    

    $('body').on('change', '.invisInput[inputmode="numeric"]', function() { f($(this)); });
    $('body').on('change', "#fGroups > .fGroup > .ftGroup > tbody > tr:not(ftSubitems) > td:nth-child(6) > .invisInput", function(e) {
      
    var firstL = $(this).val().substring($(this).val().length - 1, $(this).val().length);
    if(firstL >= '0' && firstL <= '9')
    {
      $(this).val($(this).val() + '%');
    }
    var val = $(this).val().substring(0, $(this).val().length - 1).replaceAll(',', '');
    if (val > 99)
    {
        $(this).val('99%');
        val = 99;
    }
    val = parseFloat(val);
    val = val.toFixed(2);
    var tr = $(this).parent().parent();
    var symbol = tr.children(':nth-child(5)').children(':first').val().substring(0, 1);
    var quantity = tr.children(':nth-child(4)').children(':first').val().replaceAll(',', '');
    var cost = tr.children(':nth-child(5)').children(':first').val().substring(1, tr.children(':nth-child(5)').children(':first').val().length).replaceAll(',', '');
    var total = parseFloat(cost / (100 - val) * 100 * quantity);
    total = total.toFixed(2);
    tr.children(':nth-child(7)').children(':first').val(z1(total, symbol)).change();
    $(this).val(z(val) + '%');
  });
  $('body').on('change', "#fGroups > .fGroup > .ftGroup > tbody > tr:not(ftSubitems) > td:nth-child(5) > .invisInput", function(e) {
    var firstL = $(this).val().substring(0, 1);
    if(firstL >= '0' && firstL <= '9')
    {
      $(this).val('$' + $(this).val());
    }
    
    var cost = $(this).val().substring(1, $(this).val().length).replaceAll(',', '');
    var tr = $(this).parent().parent();
    var symbol = tr.children(':nth-child(5)').children(':first').val().substring(0, 1);
    var quantity = tr.children(':nth-child(4)').children(':first').val().replaceAll(',', '');
    var val = tr.children(':nth-child(6)').children(':first').val().substring(0, tr.children(':nth-child(6)').children(':first').val().length - 1).replaceAll(',', '');
    var total = parseFloat(cost / (100 - val) * 100 * quantity);
    total = total.toFixed(2);
    tr.children(':nth-child(7)').children(':first').val(z1(total, symbol)).change();
  });
  $('body').on('change', "#fGroups > .fGroup > .ftGroup > tbody > tr:not(ftSubitems) > td:nth-child(4) > .invisInput", function(e) {
    var quantity = $(this).val().replaceAll(',', '');
    var tr = $(this).parent().parent();
    var symbol = tr.children(':nth-child(5)').children(':first').val().substring(0, 1);
    var cost = tr.children(':nth-child(5)').children(':first').val().substring(1, tr.children(':nth-child(5)').children(':first').val().length).replaceAll(',', '');
    var val = tr.children(':nth-child(6)').children(':first').val().substring(0, tr.children(':nth-child(6)').children(':first').val().length - 1).replaceAll(',', '');
    var total = parseFloat(cost / (100 - val) * 100 * quantity);
    total = total.toFixed(2);
    tr.children(':nth-child(7)').children(':first').val(z1(total, symbol)).change();
  });
  $('body').on('change', "#fGroups > .fGroup > .ftGroup > tbody > tr:not(ftSubitems) > td:nth-child(7) > .invisInput", function(e) {
    var firstL = $(this).val().substring(0, 1);
    if(firstL >= '0' && firstL <= '9')
    {
      $(this).val('$' + $(this).val());
    }
    var total = parseFloat($(this).val().substring(1, $(this).val().length).replaceAll(',', ''));
    total = total.toFixed(2);
    var tr = $(this).parent().parent();
    var symbol = tr.children(':nth-child(5)').children(':first').val().substring(0, 1);
    var quantity = tr.children(':nth-child(4)').children(':first').val().replaceAll(',', '');
    var cost = tr.children(':nth-child(5)').children(':first').val().substring(1, tr.children(':nth-child(5)').children(':first').val().length).replaceAll(',', '');
    if(total != 0)
    {
        var utility =parseFloat(100 - cost * 100 * quantity / total);
        utility = utility.toFixed(2);
        tr.children(':nth-child(6)').children(':first').val(z(utility) + '%');
    }
    $(this).val(z1(total, symbol));
    getTotalSum();
  });
	$('body').on('change', ".ftSITable > tbody > tr:not(ftNewSI) > td:nth-child(4) > .invisInput", function(e) {
    var symbol = $(this).parent().parent().children(':nth-child(5)').children().first().text().substring(0, 1);
    if(symbol == "" || symbol == null)
      symbol = '$';
    var TR = $(this).parent().parent(), tBody = TR.parent(), sum = 0;
    var text = TR.children().eq(4).children().first().val();

    if(text.substring(0, 1) >= '0' && text.substring(0, 1) <= '9')
    {
      TR.children().eq(4).children().first().val(symbol + text);
    }

    text = text.substring(1, text.length);
        if(!isNaN(Number.parseInt($(this).val().replaceAll(",", "")) * Number.parseFloat(text.replaceAll(",", ""))))
        {
            TR.children().eq(5).children().first().val(z1(Number.parseInt($(this).val().replaceAll(",", "")) * 
			Number.parseFloat(text.replaceAll(",", "")), symbol));
		    checkSITotal(tBody, symbol);
		
        }
        f($(this));
    });
	$('body').on('change', ".ftSISmall > table > tbody > tr:nth-child(4) > td:last-child > .invisInput", function(e) {
    var symbol = $(this).parent().parent().children(':nth-child(5)').children().first().text().substring(0, 1);
    if(symbol == "" || symbol == null)
      symbol = '$';
        var tBody = $(this).parent().parent().parent(), bigTBody = tBody.parent().parent().parent().parent().parent();
        if(!isNaN(Number.parseInt($(this).val().replaceAll(",", "")) * Number.parseFloat(tBody.children().eq(3).children().last().children().first().val().replaceAll(",", ""))))
        {
            tBody.children().eq(4).children().last().children().first().val(z(
                Number.parseInt($(this).val().replaceAll(",", "")) * 
                Number.parseFloat(tBody.children().eq(3).children().last().children().first().val().replaceAll(",", ""))));
            
            checkSITotalSmall(bigTBody, symbol);
        }
        
    });
	$('body').on('change', ".ftSITable > tbody > tr:not(ftNewSI) > td:nth-child(5) > .invisInput", function(e) {
    var symbol = $(this).text().substring(0, 1);
    if(symbol == "" || symbol == null)
      symbol = '$';
    var text = $(this).val();
    
    if(text.substring(0, 1) >= '0' && text.substring(0, 1) <= '9')
    {
      $(this).val(symbol + text);
    }
    text = $(this).val().substring(1, $(this).val().length);
    
        var TR = $(this).parent().parent(), tBody = TR.parent();
        if(!isNaN(Number.parseFloat(text.replaceAll(",", "")) * Number.parseInt(TR.children().eq(3).children().first().val().replaceAll(",", ""))))
        {
            TR.children().eq(5).children().first().val(z1(Number.parseFloat(text.replaceAll(",", "")) * 
			Number.parseInt(TR.children().eq(3).children().first().val().replaceAll(",", "")), symbol));
		checkSITotal(tBody, symbol);
        }
        
    f($(this));
    });
	$('body').on('change', ".ftSISmall > table > tbody > tr:nth-child(5) > td:last-child > .invisInput", function(e) {
    var symbol = $(this).text().substring(0, 1);
    if(symbol == "" || symbol == null)
      symbol = '$';

    var text = $(this).val();
    if(text.substring(0, 1) < '0' && text.substring(0, 1) > '9')
      $(this).val(symbol + text);
    text = $(this).val().substring(1, $(this).val().length);

		var tBody = $(this).parent().parent().parent(), bigTBody = tBody.parent().parent().parent().parent().parent();
        tBody.children().eq(6).children().last().children().first().val(z(
			Number.parseFloat(text.replaceAll(",", "")) * 
			Number.parseInt(tBody.children().eq(2).children().last().children().first().val().replaceAll(",", ""))));
		checkSITotalSmall(bigTBod, symboly);
    f($(this));
    $(this).val(symbol + $(this).val());
    });
	$('body').on('change', ".ftSITable > tbody > tr:not(ftNewSI) > td:nth-child(6) > .invisInput", function(e) {
    var symbol = $(this).parent().parent().children(':nth-child(4)').children().first().text().substring(0, 1);
    if(symbol == "" || symbol == null)
      symbol = '$';
		checkSITotal($(this).parent().parent().parent(), symbol);
		f($(this));
    });
	$('body').on('change', ".ftSISmall > table > tbody > tr:nth-child(6) > td:last-child > .invisInput", function(e) {
    var symbol = $(this).parent().parent().children(':nth-child(4)').children().first().text().substring(0, 1);
    if(symbol == "" || symbol == null)
      symbol = '$';
		checkSITotalSmall($(this).parent().parent().parent().parent().parent().parent().parent().parent(), symbol);
		f($(this));
    });
	$(function(){
        $('body').on('keypress', '.invisInput[inputmode="numeric"][placeholder!="Quantity"]', function(e) {
            if (!String.fromCharCode(e.which).match(/[0-9+,.]/)) return false;
        });
        $('body').on('keypress', '.invisInput[inputmode="numeric"][placeholder="Quantity"]', function(e) {
            if (!String.fromCharCode(e.which).match(/[0-9+,]/)) return false;
        });
    });
  

// Screen Sizes
function isBigDevice() {
	return $(window).width() > 700;
}
/*function isTooSmallDevice() {
	return $(window).width() < 400;
}*/
function htmlOFCell(e) {
	var cellInput = e.children().first();
	return '<tr>\
      <td>'+cellInput.attr("placeholder")+'</td>\
      <td><input type="text" inputmode="numeric" class="font1 invisInput" placeholder="'+cellInput.attr("placeholder")+'" value="'+cellInput.val()+'"></td>\
    </tr>';
}
function htmlSISmallCell(e, isNumeric, button, show) {
	var cellInput = e.children().first(),
		btn = '<img src="'+baseurl+'fav_positive.svg" class="ftSIOFIcon">',
		display = '', numeric = '';
	if (!button) btn = '';
	if (!show) display = ' style="display: none;"';
	if (isNumeric) numeric = ' inputmode="numeric"';
	return '<tr'+display+'>\
      <td>'+btn + cellInput.attr("placeholder")+'</td>\
      <td><input type="text"'+numeric+' class="font1 invisInput" placeholder="'+cellInput.attr("placeholder")+'" value="'+cellInput.val()+'"></td>\
    </tr>';
}
function scrSizes() {
	var itemNames = $("#fGroups > .fGroup > .ftGroup > tbody > tr:not(.ftNew) > td:nth-child(3)"),
		subitemNames = $(".ftSITable > tbody > tr:not(.ftNewSI)");
	if (isBigDevice()) {
		itemNames.removeAttr("colspan");
		itemNames.each(function() {
			var OF = $(this).children(".ftOverflow"),
				tBody = OF.children().first().children().first(),
				field2 = tBody.children().eq(0).children().last().children().first().val(),
				field3 = tBody.children().eq(1).children().last().children().first().val(),
				field4 = tBody.children().eq(2).children().last().children().first().val(),
				field5 = tBody.children().eq(3).children().last().children().first().val(),
				mainTR = OF.parent().parent();
			mainTR.children().eq(3).children().first().val(field2);
			mainTR.children().eq(4).children().first().val(field3);
			mainTR.children().eq(5).children().first().val(field4);
			mainTR.children().eq(6).children().first().val(field5);
			OF.remove();
		});
		
		subitemNames.each(function() {
			if ($(this).has(".ftSISmall").length == 0) return;
			var tinyTBody = $(this).children().first().children().first().children().last().children().first(),
				field1 = tinyTBody.children().eq(0).children().last().children().first(),
				field2 = tinyTBody.children().eq(1).children().last().children().first(),
				field3 = tinyTBody.children().eq(2).children().last().children().first(),
				field4 = tinyTBody.children().eq(3).children().last().children().first(),
				field5 = tinyTBody.children().eq(4).children().last().children().first();
			$(this).append('<td>\
                            <input type="text" class="font1 invisInput" placeholder="Material" value="'+field1.val()+'">\
                          </td>\
                          <td>\
                            <input type="text" class="font1 invisInput" placeholder="Provider" value="'+field2.val()+'">\
                          </td>\
                          <td>\
                            <input type="text" inputmode="numeric" class="font1 invisInput" placeholder="Quantity" value="'+field3.val()+'">\
                          </td>\
                          <td>\
                            <input type="text" inputmode="numeric" class="font1 invisInput" placeholder="Cost" value="'+field4.val()+'">\
                          </td>\
                          <td>\
                            <input type="text" inputmode="numeric" class="font1 invisInput" placeholder="Total" value="'+field5.val()+'" readonly>\
                            <img src="'+baseurl+'trash.svg" class="ftDeleteSI">\
                          </td>');
			$(this).children().first().remove();
		});
	} else {
		itemNames.attr("colspan", "2");
		itemNames.each(function() {
			if ($(this).has(".ftOverflow").length == 1) return;// RETURNING "FALSE" CAUSED A COMPLICATED ERROR!!!
			var TR = $(this).parent();
			$(this).append('<div class="ftOverflow">\
                           <table>\
                             <tbody>\
                               '+htmlOFCell(TR.children().eq(3))+'\
                               '+htmlOFCell(TR.children().eq(4))+'\
                               '+htmlOFCell(TR.children().eq(5))+'\
                               '+htmlOFCell(TR.children().eq(6))+'\
						     </tbody>\
						   </table>\
						 </div>');
			$(this).children().last().slideUp(1);
			$(this).children().first().attr("src", baseurl + "fav_positive.svg");
		});
		
		subitemNames.each(function() {
			if ($(this).has(".ftSISmall").length == 1) return;
			var cell1 = $(this).children().eq(0),
				cell2 = $(this).children().eq(1),
				cell3 = $(this).children().eq(2),
				cell4 = $(this).children().eq(3),
			    cell5 = $(this).children().eq(4);
			$(this).append('<td colspan="5">\
                             <div class="ftSISmall">\
                               <img src="'+baseurl+'trash.svg" class="ftDeleteSI">\
                               <table>\
                                 <tbody>\
                                   '+htmlSISmallCell(cell1, false, true, true)+'\
                                   '+htmlSISmallCell(cell2, false, false, false)+'\
                                   '+htmlSISmallCell(cell3, true, false, false)+'\
                                   '+htmlSISmallCell(cell4, true, false, false)+'\
                                   '+htmlSISmallCell(cell5, true, false, false)+'\
                                 </tbody>\
                               </table>\
                             </div>\
						   </td>');
			cell1.remove();
			cell2.remove();
			cell3.remove();
			cell4.remove();
			cell5.remove();
		});
	}
}
//$(window).resize(function(){scrSizes();});
//scrSizes();



//service
$('body').on('change', "#serviceGroup > .ftGroup > tbody > tr:not(ftSubitems) > td:nth-child(6) > .invisInput", function(e) {
    var firstL = $(this).val().substring($(this).val().length - 1, $(this).val().length);
    if(firstL >= '0' && firstL <= '9')
    {
      $(this).val($(this).val() + '%');
    }
    var val = $(this).val().substring(0, $(this).val().length - 1).replaceAll(',', '');
    if (val > 99)
    {
        $(this).val('99%');
        val = 99;
    }
    val = parseFloat(val);
    val = val.toFixed(2);
    var tr = $(this).parent().parent();
    var symbol = tr.children(':nth-child(5)').children(':first').val().substring(0, 1);
    var cost = tr.children(':nth-child(5)').children(':first').val().substring(1, tr.children(':nth-child(5)').children(':first').val().length).replaceAll(',', '');
    var total = parseFloat(cost / (100 - val) * 100);
    total = total.toFixed(2);
    tr.children(':nth-child(7)').children(':first').val(z1(total, symbol)).change();
    $(this).val(z(val) + '%');
  });
  $('body').on('change', "#serviceGroup > .ftGroup > tbody > tr:not(ftSubitems) > td:nth-child(5) > .invisInput", function(e) {
    var firstL = $(this).val().substring(0, 1);
    if(firstL >= '0' && firstL <= '9')
    {
      $(this).val('$' + $(this).val());
    }
    
    var cost = $(this).val().substring(1, $(this).val().length).replaceAll(',', '');
    var tr = $(this).parent().parent();
    var symbol = tr.children(':nth-child(5)').children(':first').val().substring(0, 1);
    var val = tr.children(':nth-child(6)').children(':first').val().substring(0, tr.children(':nth-child(6)').children(':first').val().length - 1).replaceAll(',', '');
    var total = parseFloat(cost / (100 - val) * 100);
    total = total.toFixed(2);
    tr.children(':nth-child(7)').children(':first').val(z1(total, symbol)).change();
  });
  $('body').on('change', "#serviceGroup > .ftGroup > tbody > tr:not(ftSubitems) > td:nth-child(7) > .invisInput", function(e) {
    var firstL = $(this).val().substring(0, 1);
    if(firstL >= '0' && firstL <= '9')
    {
      $(this).val('$' + $(this).val());
    }
    var total = parseFloat($(this).val().substring(1, $(this).val().length).replaceAll(',', ''));
    total = total.toFixed(2);
    var tr = $(this).parent().parent();
    var symbol = tr.children(':nth-child(5)').children(':first').val().substring(0, 1);
    var cost = tr.children(':nth-child(5)').children(':first').val().substring(1, tr.children(':nth-child(5)').children(':first').val().length).replaceAll(',', '');
    if(total != 0)
    {
        var utility =parseFloat(100 - cost * 100 / total);
        utility = utility.toFixed(2);
        tr.children(':nth-child(6)').children(':first').val(z(utility) + '%');
    }
    $(this).val(z1(total, symbol));
    getTotalSum();
  });

  //employee
  $('body').on('change', "#employeeGroup > .ftGroup > tbody > tr:not(ftSubitems) > td:nth-child(4) > .invisInput", function(e) {
    var val = $(this).val().replaceAll(',', '');
    val = parseFloat(val);
    val = val.toFixed(2);
    var tr = $(this).parent().parent();
    var symbol = tr.children(':nth-child(5)').children(':first').val().substring(0, 1);
    var cost = tr.children(':nth-child(5)').children(':first').val().substring(1, tr.children(':nth-child(5)').children(':first').val().length).replaceAll(',', '');
    var total = parseFloat(cost * val);
    total = total.toFixed(2);
    tr.children(':nth-child(6)').children(':first').val(z1(total, symbol)).change();
  });
  $('body').on('change', "#employeeGroup > .ftGroup > tbody > tr:not(ftSubitems) > td:nth-child(5) > .invisInput", function(e) {
    var firstL = $(this).val().substring(0, 1);
    if(firstL >= '0' && firstL <= '9')
    {
      $(this).val('$' + $(this).val());
    }
    
    var cost = $(this).val().substring(1, $(this).val().length).replaceAll(',', '');
    var tr = $(this).parent().parent();
    var symbol = tr.children(':nth-child(5)').children(':first').val().substring(0, 1);
    var val = tr.children(':nth-child(4)').children(':first').val().replaceAll(',', '');
    var total = parseFloat(cost * val);
    total = total.toFixed(2);
    tr.children(':nth-child(6)').children(':first').val(z1(total, symbol)).change();
    //$(this).val(z1(parseFloat(cost).toFixed(2), symbol));
  });

  $('body').on('change', "#employeeGroup > .ftGroup > tbody > tr:not(ftSubitems) > td:nth-child(6) > .invisInput", function(e) {
    getTotalSum();
  });

//preview
